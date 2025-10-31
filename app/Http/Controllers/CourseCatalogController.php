<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseCatalogController extends Controller
{
    /**
     * Display the public course catalog.
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => trim($request->query('q', '')),
            'category' => $request->query('category'),
            'level' => $request->query('level'),
        ];

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

        $courses = $query
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get(['category_id', 'name', 'slug']);

        $levelOptions = [
            'beginner' => 'Pemula',
            'intermediate' => 'Menengah',
            'advanced' => 'Lanjutan',
        ];

        return view('courses.index', [
            'courses' => $courses,
            'categories' => $categories,
            'filters' => $filters,
            'levelOptions' => $levelOptions,
        ]);
    }
}
