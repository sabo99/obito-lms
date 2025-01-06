<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $category_id
 * @property string $slug
 * @property string $name
 * @property string $thumbnail
 * @property string $about
 * @property int $is_popular
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CourseBenefit> $benefits
 * @property-read int|null $benefits_count
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CourseMentor> $courseMentors
 * @property-read int|null $course_mentors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CourseSection> $courseSections
 * @property-read int|null $course_sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CourseStudent> $courseStudents
 * @property-read int|null $course_students_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereIsPopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'category_id',
        'slug',
        'name',
        'thumbnail',
        'about',
        'is_popular',
    ];

    /**
     * ================================
     * Accessors and Mutators
     * ================================
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * ================================
     * Relationships
     * ================================
     */
    public function benefits(): HasMany
    {
        return $this->hasMany(CourseBenefit::class);
    }

    public function courseSections(): HasMany
    {
        return $this->hasMany(CourseSection::class, 'course_id');
    }

    public function courseStudents(): HasMany
    {
        return $this->hasMany(CourseStudent::class, 'course_id');
    }

    public function courseMentors(): HasMany
    {
        return $this->hasMany(CourseMentor::class, 'course_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * ================================
     * Custom Methods
     * ================================
     */
    public function getContentCountAttribute(): int
    {
        return $this->courseSections->sum(
            fn(CourseSection $section) => $section->sectionContents->count()
        );
    }
}
