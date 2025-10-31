<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function __invoke(Request $request)
    {
        $student = $request->user();

        $activeEnrollments = $student
            ->enrollments()
            ->with(['course.instructor'])
            ->where('is_completed', false)
            ->orderByDesc('enrolled_at')
            ->get();

        $completedEnrollments = $student
            ->enrollments()
            ->with(['course.instructor'])
            ->where('is_completed', true)
            ->orderByDesc('completed_at')
            ->limit(5)
            ->get();

        $activeCourseIds = $student->enrollments()->pluck('course_id');

        $pendingPaymentsQuery = $student
            ->payments()
            ->pending();

        $pendingCourseIds = (clone $pendingPaymentsQuery)->pluck('course_id');

        $pendingPayments = $pendingPaymentsQuery
            ->with('course.instructor')
            ->latest('created_at')
            ->limit(5)
            ->get();

        $recommendedCourses = Course::with(['instructor'])
            ->whereNotIn('course_id', $activeCourseIds)
            ->whereNotIn('course_id', $pendingCourseIds)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        $metrics = [
            'total_courses' => $student->enrollments()->count(),
            'active_courses' => $activeEnrollments->count(),
            'completed_courses' => $student->enrollments()->where('is_completed', true)->count(),
            'total_spent' => $student
                ->payments()
                ->where('status', 'success')
                ->sum('amount') ?? 0,
        ];

        return view('dashboard.student.dashboard', [
            'student' => $student,
            'metrics' => $metrics,
            'activeEnrollments' => $activeEnrollments,
            'completedEnrollments' => $completedEnrollments,
            'recommendedCourses' => $recommendedCourses,
            'pendingPayments' => $pendingPayments,
        ]);
    }
}
