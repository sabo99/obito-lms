<?php

namespace App\Repositories\Pricing;

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

    /**
     * Find a pricing by its ID.
     * @param int $id
     * @return Pricing|null
     */
    public function findById(int $id): ?Pricing
    {
        return $this->pricing->find($id);
    }

    /**
     * Get all pricing records.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->pricing->all();
    }

    /**
     * Check if a user is subscribed to a pricing.
     * @param int $userId
     * @param int $pricingId
     * @return bool
     */
    public function isSubscribedByUser(int $userId, int $pricingId): bool
    {
        $pricing = $this->findById($pricingId);

        return $pricing->transactions()
            ->where('user_id', $userId)
            ->where('is_paid', true)
            ->where('ended_at', '>=', now())
            ->exists();
    }
}
