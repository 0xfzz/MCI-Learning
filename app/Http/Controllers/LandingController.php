<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    /**
     * Display the landing page with featured courses and testimonials.
     */
    public function index()
    {
        // Get featured courses (6 most popular published courses)
        $featuredCourses = Course::query()
            ->with([
                'instructor:user_id,name',
                'category:category_id,name',
            ])
            ->withCount([
                'enrollments as students_count',
            ])
            ->withAvg('reviews as average_rating', 'rating')
            ->where('status', 'published')
            ->orderByDesc('students_count')
            ->limit(6)
            ->get()
            ->map(function ($course) {
                return [
                    'course_id' => $course->course_id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'thumbnail' => $course->thumbnail,
                    'category' => $course->category->name ?? 'Uncategorized',
                    'level' => $course->level,
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                    'is_paid' => $course->is_paid,
                    'students_count' => $course->students_count ?? 0,
                    'average_rating' => round($course->average_rating ?? 0, 1),
                    'reviews_count' => $course->reviews()->count(),
                    'instructor_name' => $course->instructor->name ?? 'Unknown',
                ];
            });

        // Get top testimonials (3 highest rated reviews with comments)
        $testimonials = Review::query()
            ->with([
                'user:user_id,name',
                'course:course_id,title',
            ])
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->where('rating', '>=', 4)
            ->orderByDesc('rating')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get()
            ->map(function ($review) {
                return [
                    'name' => $review->user->name ?? 'Anonymous',
                    'role' => 'Student', // You can enhance this with user roles if needed
                    'avatar' => $this->getInitials($review->user->name ?? 'Anonymous'),
                    'text' => $review->comment,
                    'rating' => $review->rating,
                    'course' => $review->course->title ?? '',
                ];
            });

        // Get statistics for the hero section
        $stats = [
            'total_students' => DB::table('enrollments')->distinct('user_id')->count(),
            'total_courses' => Course::where('status', 'published')->count(),
            'total_instructors' => DB::table('users')->where('role', 'instructor')->count(),
            'average_rating' => round(Review::avg('rating') ?? 0, 1),
        ];

        return view('landing', [
            'featuredCourses' => $featuredCourses,
            'testimonials' => $testimonials,
            'stats' => $stats,
        ]);
    }

    /**
     * Get initials from a name for avatar display.
     */
    private function getInitials(string $name): string
    {
        $words = explode(' ', trim($name));

        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($name, 0, 2));
    }
}
