<?php

namespace App\Services\Transaction;

use App\Repositories\Pricing\PricingRepositoryInterface as PricingRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface as TransactionRepository ;
use App\Services\PricingService;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    /**
     * TransactionService constructor.
     *
     * Initializes the TransactionService class.
     */
    public function __construct(
        protected PricingService $pricingService,
        protected PricingRepository $pricingRepository,
        protected TransactionRepository $transactionRepository,
    ) {}

    /**
     * Prepares the checkout process for a given pricing ID.
     *
     * @param int $pricingId The ID of the pricing to be used for checkout.
     * @return array[] An array containing the necessary data for the checkout process,
     *  includes the following keys: "user", "pricing", "alreadySubscribed", "started_at", "ended_at", "sub_total_amount", "total_tax_amount", and "grand_total_amount".
     */
    public function prepareCheckout(int $pricingId): array
    {
        $user = Auth::user();
        $alreadySubscribed = $this->pricingRepository->isSubscribedByUser($user->id, $pricingId);

        $priceWithTax = $this->pricingService->calculatePriceWithTax($pricingId);
        $pricing = $priceWithTax->pricing;
        $sub_total_amount = $priceWithTax->subTotal;
        $total_tax_amount = $priceWithTax->totalTax;
        $grand_total_amount = $priceWithTax->grandTotal;

        $started_at = now();
        $ended_at = $started_at->copy()->addDays($pricing->duration);

        session()->put('pricing_id', $pricing->id);

        return compact(
            'user',
            'pricing',
            'alreadySubscribed',
            'started_at',
            'ended_at',
            'sub_total_amount',
            'total_tax_amount',
            'grand_total_amount'
        );
    }

    /**
     * Retrieve the most recent pricing information.
     *
     * @return \App\Models\Pricing|null The most recent pricing data.
     */
    public function getRecentPricing(): ?\App\Models\Pricing
    {
        $pricingId = session()->get('pricing_id');
        return $this->pricingRepository->findById($pricingId);
    }

    /**
     * Retrieve the transactions associated with the user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUserTransactions(): \Illuminate\Support\Collection
    {
        $user = Auth::user();
        if (!($user instanceof \App\Models\User)) {
            return collect();
        }

        return $this->transactionRepository->getUserTransaction($user->id);
    }
}
