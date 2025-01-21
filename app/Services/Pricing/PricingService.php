<?php

namespace App\Services;

use App\Repositories\PricingRepositoryInterface;

class PricingService
{
    /**
     * Create a new class instance.
     * @param PricingRepositoryInterface $pricingRepository - The repository instance
     */
    public function __construct(
        protected PricingRepositoryInterface $pricingRepository
    ) {
        //
    }

    public function getAllPackages()
    {
        return $this->pricingRepository->getAll();
    }
}
