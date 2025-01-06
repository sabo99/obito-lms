<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $course_section_id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\CourseSection $courseSection
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent whereCourseSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SectionContent withoutTrashed()
 *
 * @mixin \Eloquent
 */
class SectionContent extends Model
{
    use SoftDeletes;

    protected $table = 'section_contents';

    protected $fillable = [
        'course_section_id',
        'name',
        'content',
    ];

    /**
     * ================================
     * Relationships
     * ================================
     */
    public function courseSection(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }
}
