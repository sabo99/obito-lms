<?php

namespace App\Services\Course;

use App\Models\User;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CourseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CourseRepositoryInterface $courseRepository
    ) {}

    public function enrollUser(int $courseId): ?string
    {
        $user = Auth::user();
        if (!($user instanceof User)) {
            return null;
        }

        $course = $this->courseRepository->findById($courseId);
        if (!$course) {
            return null;
        }

        $courseExists = $course->courseStudents()
            ->where('user_id', $user->id)
            ->exists();

        if (!$courseExists) {
            $course->courseStudents()
                ->create([
                    'user_id' => $user->id,
                    'is_active' => true,
                ]);
        }

        return $user->name;
    }

    public function getFirstSectionAndContent(int $courseId): array
    {
        $course = $this->courseRepository->findById($courseId);
        $firstSectionId = $course?->courseSections()->orderBy('position')->value('id');;
        $firstContentId = $course?->courseSections()->find($firstSectionId)?->sectionContents()->orderBy('id')->value('id');

        return [
            'firstSectionId' => $firstSectionId,
            'firstContentId' => $firstContentId,
        ];
    }


    public function getLearningData(int $courseId, int $courseSectionId, int $sectionContentId): array
    {
        $course = $this->courseRepository->findById($courseId);
        $course->load(['courseSections.sectionContents']);

        $currentSection = $course->courseSections->find($courseSectionId);
        $currentContent = $currentSection?->sectionContents->find($sectionContentId);

        $nextContent = null;
        if ($currentSection) {
            $nextContent = $currentSection->sectionContents
                ->where('id', '>', $currentContent->id)
                ->sortBy('id')
                ->first();
        }

        if (!$nextContent && $currentSection) {
            $nextSection = $course->courseSections
                ->where('id', '>', $currentSection->id)
                ->sortBy('id')
                ->first();

            if ($nextSection) {
                $nextContent = $nextSection->sectionContents->sortBy('id')->first();
            }
        }

        return [
            'course' => $course,
            'currentSection' => $currentSection,
            'currentContent' => $currentContent,
            'nextContent' => $nextContent,
            'isFinished' => !$nextContent,
        ];
    }
}
