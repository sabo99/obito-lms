<?php

namespace App\Services;

use App\DTO\Price\PriceWithTaxDTO;
use App\Repositories\Pricing\PricingRepositoryInterface as PricingRepository;

class PricingService
{
    /**
     * PricingService constructor.
     *
     * Initializes the PricingService class.
     */
    public function __construct(
        protected PricingRepository $pricingRepository,
        protected float $tax
    ) {
        $this->tax = config('transaction.tax');
    }

    /**
     * Retrieve all available packages.
     *
     * This method fetches and returns an array containing details of all available packages.
     *
     * @return \Illuminate\Support\Collection An array of package details.
     */
    public function getAllPackages(): \Illuminate\Support\Collection
    {
        return $this->pricingRepository->getAll();
    }

    /**
     * Calculate price with tax.
     *
     * @param int $pricingId
     * @return \App\DTO\Price\PriceWithTaxDTO
     */
    public function calculatePriceWithTax(int $pricingId): PriceWithTaxDTO
    {
        $pricing = $this->pricingRepository->findById($pricingId);
        $subTotal = $pricing->price;
        $tax = $this->tax;
        $totalTax = $pricing->price * $tax;
        $grandTotal = $subTotal + $totalTax;

        return new PriceWithTaxDTO($pricing, $subTotal, $tax, $totalTax, $grandTotal);
    }
}
