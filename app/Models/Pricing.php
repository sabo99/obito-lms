<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int $duration
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pricing withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Pricing extends Model
{
    use SoftDeletes;

    protected $table = 'pricings';

    protected $fillable = [
        'name',
        'duration',
        'price',
    ];

    /**
     * ================================
     * Relationships
     * ================================
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * ================================
     * Custom Methods
     * ================================
     */
    public function isSubscribedByUser(int $userId): bool
    {
        return $this->transactions()
            ->where('user_id', $userId)
            ->where('is_paid', true)
            ->where('ended_at', '>=', now())
            ->exists();
    }
}
