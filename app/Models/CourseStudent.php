<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $student
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseStudent withoutTrashed()
 *
 * @mixin \Eloquent
 */
class CourseStudent extends Model
{
    use SoftDeletes;

    protected $table = 'course_students';

    protected $fillable = [
        'user_id',
        'course_id',
        'is_active',
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

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
