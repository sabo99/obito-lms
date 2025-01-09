<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $course_id
 * @property int $user_id
 * @property string $comment
 * @property float $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseTestimonial withoutTrashed()
 *
 * @mixin \Eloquent
 */
class CourseTestimonial extends Model
{
    use SoftDeletes;

    protected $table = 'course_testimonials';

    protected $fillable = [
        'course_id',
        'user_id',
        'comment',
        'rating',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
