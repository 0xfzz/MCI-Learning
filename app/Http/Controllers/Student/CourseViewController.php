<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseViewController extends Controller
{
    /**
     * Display the course content for enrolled students.
     */
    public function show(Request $request, Course $course)
    {
        $student = $request->user();

        if (!$student) {
            abort(403);
        }

        // Check if student is enrolled
        $enrollment = $student->enrollments()
            ->where('course_id', $course->course_id)
            ->first();

        if (!$enrollment) {
            return redirect()
                ->route('dashboard.my-courses.index')
                ->with('error', 'Anda belum terdaftar di kursus ini. Silakan daftar terlebih dahulu.');
        }

        // Get all lessons grouped by sections
        $sections = $course->lessons()
            ->where('is_section', true)
            ->whereNull('parent_id')
            ->ordered()
            ->with(['children' => function ($query) use ($student) {
                $query->ordered()->with(['progress' => function ($q) use ($student) {
                    $q->where('user_id', $student->user_id);
                }]);
            }])
            ->get();

        // Get standalone lessons (not in any section)
        $standaloneLessons = $course->lessons()
            ->where('is_section', false)
            ->whereNull('parent_id')
            ->ordered()
            ->with(['progress' => function ($query) use ($student) {
                $query->where('user_id', $student->user_id);
            }])
            ->get();

        // Get the first lesson or current lesson
        $currentLesson = null;
        $lessonId = $request->query('lesson');

        if ($lessonId) {
            $currentLesson = $course->lessons()
                ->where('lesson_id', $lessonId)
                ->with(['progress' => function ($query) use ($student) {
                    $query->where('user_id', $student->user_id);
                }])
                ->first();
        }

        // If no lesson specified or not found, get the first lesson
        if (!$currentLesson) {
            // Try to get first lesson from first section
            if ($sections->isNotEmpty() && $sections->first()->children->isNotEmpty()) {
                $currentLesson = $sections->first()->children->first();
            } elseif ($standaloneLessons->isNotEmpty()) {
                $currentLesson = $standaloneLessons->first();
            }
        }

        // Calculate course progress
        $totalLessons = $course->lessons()->where('is_section', false)->count();
        $completedLessons = $student->lessonProgress()
            ->whereHas('lesson', function ($query) use ($course) {
                $query->where('course_id', $course->course_id);
            })
            ->where('is_completed', true)
            ->count();

        $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        return view('dashboard.student.course-view', compact(
            'course',
            'sections',
            'standaloneLessons',
            'currentLesson',
            'enrollment',
            'totalLessons',
            'completedLessons',
            'progressPercentage'
        ));
    }

    /**
     * Mark a lesson as completed.
     */
    public function markComplete(Request $request, Course $course, $lessonId)
    {
        $student = $request->user();

        // Verify enrollment
        $enrollment = $student->enrollments()
            ->where('course_id', $course->course_id)
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        $lesson = $course->lessons()
            ->where('lesson_id', $lessonId)
            ->where('is_section', false)
            ->firstOrFail();

        $progress = $student->lessonProgress()->updateOrCreate(
            [
                'lesson_id' => $lesson->lesson_id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        // Update enrollment completion status if all lessons are completed
        $totalLessons = $course->lessons()->where('is_section', false)->count();
        $completedLessons = $student->lessonProgress()
            ->whereHas('lesson', function ($query) use ($course) {
                $query->where('course_id', $course->course_id);
            })
            ->where('is_completed', true)
            ->count();

        if ($completedLessons >= $totalLessons) {
            $enrollment->update([
                'is_completed' => true,
                'completed_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'completed' => $completedLessons,
            'total' => $totalLessons,
            'percentage' => round(($completedLessons / $totalLessons) * 100),
        ]);
    }
}
