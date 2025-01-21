<?php

namespace App\Repositories\Course;

use App\Models\Course;

class CourseRepository implements CourseRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Course $course
    ) {}

    public function findById(int $id): ?Course
    {
        return $this->course->find($id);
    }
}
