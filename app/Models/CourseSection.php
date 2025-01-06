<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $course_id
 * @property string $name
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SectionContent> $sectionContents
 * @property-read int|null $section_contents_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CourseSection withoutTrashed()
 *
 * @mixin \Eloquent
 */
class CourseSection extends Model
{
    use SoftDeletes;

    protected $table = 'course_sections';

    protected $fillable = [
        'course_id',
        'name',
        'position',
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

    public function sectionContents(): HasMany
    {
        return $this->hasMany(SectionContent::class, 'course_id');
    }
}
