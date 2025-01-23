<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * TransactionRepository constructor.
     *
     * Initializes the TransactionRepository class.
     */
    public function __construct(
        protected Transaction $transaction
    ) {}

    /**
     * Find a transaction by its ID.
     *
     * @param int $id - The ID of the transaction.
     * @return Transaction|null
     */
    public function findById(int $id): ?Transaction
    {
        return $this->transaction->find($id);
    }

    /**
     * Find a transaction by its booking ID.
     *
     * @param string $bookingId - The booking ID of the transaction.
     * @return Transaction|null
     */
    public function findByBookingId(string $bookingId): ?Transaction
    {
        return $this->transaction->where('booking_trx_id', $bookingId)->first();
    }

    /**
     * Get transactions for a specific user.
     *
     * @param int $id - The ID of the transaction.
     * @param int $userId - The ID of the user.
     * @return Collection
     */
    public function getUserTransaction(int $userId): Collection
    {
        return $this->transaction->with('pricing')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Create a new transaction.
     *
     * @param array $data - The data for the new transaction.
     * @return Transaction
     */
    public function create(array $data): Transaction
    {
        return $this->transaction->create($data);
    }
}
