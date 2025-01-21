<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

interface TransactionRepositoryInterface
{
    public function findById(int $id): ?Transaction;
    public function findByBookingId(string $bookingId): ?Transaction;
    public function getUserTransaction(int $userId): Collection;
    public function create(array $data): Transaction;
}
