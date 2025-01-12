<?php

namespace App\Repositories;

use App\Models\Pricing;
use Illuminate\Database\Eloquent\Collection;

class PricingRepository implements PricingRepositoryInterface
{
    /**
     * Create a new class instance.
     * @param Pricing $pricing - The model instance
     */
    public function __construct(
        protected Pricing $pricing
    ) {}

    public function findById(int $id): ?Pricing
    {
        return $this->pricing->find($id);
    }

    public function getAll(): Collection
    {
        return $this->pricing->all();
    }
}
