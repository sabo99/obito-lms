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
 * @property string|null $about
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $mentor
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseMentor withoutTrashed()
 *
 * @mixin \Eloquent
 */
class CourseMentor extends Model
{
    use SoftDeletes;

    protected $table = 'course_mentors';

    protected $fillable = [
        'user_id',
        'course_id',
        'about',
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

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
