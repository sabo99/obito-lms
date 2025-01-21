<?php

namespace App\Repositories\Course;

use App\Models\Course;

interface CourseRepositoryInterface
{
    public function findById(int $id): ?Course;
}
