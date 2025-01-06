<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $course_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Course $course
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseBenefit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CourseBenefit extends Model
{
    protected $table = 'course_benefits';

    protected $fillable = [
        'course_id',
        'name',
    ];

    /**
     * ================================
     * Relationships
     * ================================
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
