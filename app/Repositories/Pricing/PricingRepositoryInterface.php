<?php

namespace App\Repositories\Pricing;

use App\Models\Pricing;
use Illuminate\Database\Eloquent\Collection;

interface PricingRepositoryInterface
{
    public function findById(int $id): ?Pricing;

    public function getAll(): Collection;

    public function isSubscribedByUser(int $userId, int $pricingId): bool;
}
