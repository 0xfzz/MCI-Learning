<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the instructor's courses.
     */
    public function index(Request $request)
    {
        $instructor = $request->user();

        $filters = [
            'status' => $request->filled('status') ? $request->string('status')->lower()->value() : null,
            'q' => $request->filled('q') ? $request->string('q')->trim()->value() : null,
        ];

        $coursesQuery = $instructor
            ->taughtCourses()
            ->with(['category'])
            ->withCount('enrollments')
            ->when($filters['status'], function ($query, string $status) {
                $query->where('status', $status);
            })
            ->when($filters['q'], function ($query, string $search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at');

        $courses = $coursesQuery->paginate(10)->withQueryString();

        $baseQuery = $instructor->taughtCourses();
        $totalCourses = (clone $baseQuery)->count();
        $publishedCourses = (clone $baseQuery)->where('status', 'published')->count();
        $draftCourses = (clone $baseQuery)->where('status', 'draft')->count();
        $totalStudents = (clone $baseQuery)
            ->withCount('enrollments')
            ->get()
            ->sum('enrollments_count');

        return view('dashboard.instructor.courses.index', [
            'courses' => $courses,
            'metrics' => [
                'total' => $totalCourses,
                'published' => $publishedCourses,
                'draft' => $draftCourses,
                'students' => $totalStudents,
            ],
            'statusOptions' => [
                'published' => 'Dipublikasikan',
                'draft' => 'Draft',
            ],
            'manageLessonRoute' => fn ($course) => route('dashboard.courses.lessons.index', $course),
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('dashboard.instructor.courses.create', $this->formOptions());
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $data = $this->validateCourse($request);

        // Handle thumbnail upload if provided
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('course-thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $course = new Course($data);
        $course->instructor_id = $request->user()->user_id;
        $course->save();

        return redirect()
            ->route('dashboard.courses.lessons.index', $course)
            ->with('status', 'Kursus berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        return view('dashboard.instructor.courses.edit', array_merge(
            ['course' => $course],
            $this->formOptions(),
        ));
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        $data = $this->validateCourse($request, $course);

        // Handle thumbnail upload/replacement if provided
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $path = $request->file('thumbnail')->store('course-thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $course->fill($data);
        $course->save();

        return redirect()
            ->route('dashboard.courses.index')
            ->with('status', 'Perubahan kursus telah disimpan.');
    }

    /**
     * Remove the specified course.
     */
    public function destroy(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        $course->delete();

        return redirect()
            ->route('dashboard.courses.index')
            ->with('status', 'Kursus telah dihapus.');
    }

    /**
     * Ensure the authenticated instructor owns the course record.
     */
    private function authorizeCourse(Request $request, Course $course): void
    {
        $user = $request->user();

        // Allow admin to edit any course, or instructor to edit their own course
        if ($user->isAdmin()) {
            return;
        }

        if ((int) $course->instructor_id !== (int) $user->user_id) {
            abort(403);
        }
    }

    /**
     * Gather options shared across course forms.
     */
    private function formOptions(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(['category_id', 'name']),
            'levels' => [
                'beginner' => 'Beginner',
                'intermediate' => 'Intermediate',
                'advanced' => 'Advanced',
            ],
            'statusOptions' => [
                'draft' => 'Draft',
                'published' => 'Dipublikasikan',
            ],
        ];
    }

    /**
     * Validate incoming course data.
     */
    private function validateCourse(Request $request, ?Course $course = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,category_id'],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'level' => ['nullable', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'is_paid' => ['nullable', 'boolean'],
            'price' => ['nullable', 'integer', 'min:0', 'required_if:is_paid,1'],
            'discount_price' => ['nullable', 'integer', 'min:0', 'lte:price'],
            'whatsapp_group' => ['nullable', 'url'],
            'source_code_link' => ['nullable', 'url'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);

        $validated['is_paid'] = $request->boolean('is_paid');

        if (! $validated['is_paid']) {
            $validated['price'] = 0;
            $validated['discount_price'] = null;
        }

        return $validated;
    }
}
