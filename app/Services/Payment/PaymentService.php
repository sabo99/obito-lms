<?php

namespace App\Services\Payment;

use App\Helpers\TransactionHelper;
use App\Models\Pricing;
use App\Models\User;
use App\Repositories\Pricing\PricingRepositoryInterface as PricingRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface as TransactionRepository;
use App\Services\Midtrans\MidtransService;
use App\Services\PricingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected MidtransService $midtransService,
        protected PricingService $pricingService,
        protected PricingRepository $pricingRepository,
        protected TransactionRepository $transactionRepository,
        protected float $tax
    ) {}


    /**
     * Create a payment for the given pricing ID.
     *
     * @param int $pricingId The ID of the pricing to create a payment for.
     * @return string The result of the payment creation process.
     */
    public function createPayment(int $pricingId): string
    {
        $user = Auth::user();
        if (!($user instanceof User)) {
            throw new \Exception('User not found');
        }

        $priceWithTax = $this->pricingService->calculatePriceWithTax($pricingId);
        $pricing = $priceWithTax->pricing;
        $tax = $priceWithTax->tax;
        $totalTax = $priceWithTax->totalTax;
        $grandTotal = $priceWithTax->grandTotal;

        $params = [
            'transaction_details' => [
                'order_id' => TransactionHelper::generateUniqueTransactionId(),
                'gross_amount' => (int) $grandTotal,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $pricing->id,
                    'price' => (int) $pricing->price,
                    'quantity' => 1,
                    'name' => $pricing['name'],
                ],
                [
                    'id' => 'tax',
                    'price' => (int) $totalTax,
                    'quantity' => 1,
                    'name' => 'PPN ' . $tax * 100 . '%',
                ]
            ],
            'custom_field1' => $user->id,
            'custom_field2' => $pricing->id,
        ];

        return $this->midtransService->createSnapToken($params);
    }

    /**
     * Handles the payment notification.
     *
     * @return string The result of the payment notification handling.
     */
    public function handlePaymentNotification(): string
    {
        $notification = $this->midtransService->handleNotification();

        if (in_array($notification['transaction_status'], ['capture', 'settlement'])) {
            $pricing = $this->pricingRepository->findById($notification['custom_field2']);

            $this->_createTransaction($notification, $pricing);
        }

        return $notification['transaction_status'];
    }

    /**
     * Creates a transaction based on the provided notification and pricing information.
     *
     * @param array $notification The notification data used to create the transaction.
     * @param Pricing|null $pricing The pricing information, or null if not applicable.
     *
     * @return void
     */
    private function _createTransaction(array $notification, ?Pricing $pricing): void
    {
        $started_at = now();
        $ended_at = $started_at->copy()->addDays($pricing->duration);

        $priceWithTax = $this->pricingService->calculatePriceWithTax($pricing->id);

        $transactionData = [
            'user_id' => $notification['custom_field1'],
            'pricing_id' => $notification['custom_field2'],
            'sub_total_amount' => $priceWithTax->subTotal,
            'total_tax_amount' => $priceWithTax->totalTax,
            'grand_total_amount' => $priceWithTax->grandTotal,
            'payment_type' => $notification['payment_type'] ?? 'Midtrans',
            'is_paid' => true,
            'booking_trx_id' => $notification['order_id'],
            'started_at' => $started_at,
            'ended_at' => $ended_at,
        ];

        $this->transactionRepository->create($transactionData);

        Log::info('Transaction successfully created', [
            'booking_trx_id' => $notification['order_id'],
        ]);
    }
}
