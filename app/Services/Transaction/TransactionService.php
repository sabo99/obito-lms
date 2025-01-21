<?php

namespace App\Services\Transaction;

use App\Repositories\Pricing\PricingRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    /**
     * TransactionService handles the business logic related to transactions.
     */
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected PricingRepositoryInterface $pricingRepository
    ) {}

    public function prepareCheckout(int $pricingId)
    {
        $user = Auth::user();
        $pricing = $this->pricingRepository->findById($pricingId);
        $alreadySubscribed = $this->pricingRepository->isSubscribedByUser($user->id, $pricingId);

        $tax = 0.11;
        $sub_total_amount = $pricing->price;
        $total_tax_amount = $pricing->price * $tax;
        $grand_total_amount = $sub_total_amount + $total_tax_amount;

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

    public function getRecentPricing()
    {
        $pricingId = session()->get('pricing_id');
        return $this->pricingRepository->findById($pricingId);
    }

    public function getUserTransactions()
    {
        $user = Auth::user();
        if (!($user instanceof \App\Models\User)) {
            return collect();
        }

        return $this->transactionRepository->getUserTransaction($user->id);
    }
}
