<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseListController extends Controller
{
    /**
     * Display the course catalog for students.
     */
    public function index(Request $request)
    {
        $student = $request->user();

        $filters = [
            'search' => trim($request->query('q', '')),
            'category' => $request->query('category'),
            'level' => $request->query('level'),
            'type' => $request->query('type'), // 'all', 'free', 'premium'
        ];

        // Get enrolled course IDs
        $enrolledCourseIds = $student->enrollments()->pluck('course_id');

        // Get pending payment course IDs
        $pendingCourseIds = $student
            ->payments()
            ->pending()
            ->pluck('course_id');

        $query = Course::query()
            ->with([
                'instructor:user_id,name,username',
                'category:category_id,name,slug',
            ])
            ->withCount([
                'lessons as lessons_count' => function ($lessonQuery) {
                    $lessonQuery->videos();
                },
                'enrollments as students_count',
            ])
            ->where('status', 'published');

        if ($filters['search'] !== '') {
            $query->where(function ($subQuery) use ($filters) {
                $subQuery
                    ->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('description', 'like', '%'.$filters['search'].'%');
            });
        }

        if ($filters['category']) {
            $query->whereHas('category', function ($categoryQuery) use ($filters) {
                $categoryQuery->where('slug', $filters['category']);
            });
        }

        if ($filters['level'] && in_array($filters['level'], ['beginner', 'intermediate', 'advanced'], true)) {
            $query->where('level', $filters['level']);
        }

        if ($filters['type'] === 'free') {
            $query->where('is_paid', false);
        } elseif ($filters['type'] === 'premium') {
            $query->where('is_paid', true);
        }

        $courses = $query
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        // Add enrollment status to each course
        foreach ($courses as $course) {
            $course->is_enrolled = $enrolledCourseIds->contains($course->course_id);
            $course->has_pending_payment = $pendingCourseIds->contains($course->course_id);
        }

        $categories = Category::orderBy('name')->get(['category_id', 'name', 'slug']);

        $levelOptions = [
            'beginner' => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced' => 'Lanjutan',
        ];

        $typeOptions = [
            'all' => 'Semua',
            'free' => 'Gratis',
            'premium' => 'Premium',
        ];

        return view('dashboard.student.courses', [
            'courses' => $courses,
            'categories' => $categories,
            'filters' => $filters,
            'levelOptions' => $levelOptions,
            'typeOptions' => $typeOptions,
        ]);
    }
}
