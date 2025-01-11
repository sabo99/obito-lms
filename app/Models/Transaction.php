<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $booking_trx_id
 * @property int $user_id
 * @property int $pricing_id
 * @property int $sub_total_amount
 * @property int $grand_total_amount
 * @property int $total_tax_amount
 * @property int $is_paid
 * @property string $payment_type
 * @property string|null $payment_proof
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Pricing $pricing
 * @property-read \App\Models\User $student
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereBookingTrxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereGrandTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaymentProof($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePricingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSubTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereTotalTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[ObservedBy([TransactionObserver::class])]
class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'booking_trx_id',
        'user_id',
        'pricing_id',
        'sub_total_amount',
        'grand_total_amount',
        'total_tax_amount',
        'is_paid',
        'payment_type',
        'payment_proof',
        'started_at',
        'ended_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'ended_at' => 'date',
        ];
    }

    /**
     * ================================
     * Relationships
     * ================================
     */
    public function pricing(): BelongsTo
    {
        return $this->belongsTo(Pricing::class, 'pricing_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * ================================
     * Custom Methods
     * ================================
     */
    public function isActive(): bool
    {
        return $this->is_paid && $this->ended_at->isFuture();
    }
}
