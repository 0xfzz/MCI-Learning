<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instructor\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LessonController extends Controller
{
    /**
     * Display a listing of the lessons for a course.
     */
    public function index(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        $sections = $course->sections()->with(['children' => function ($query) {
            $query->ordered();
        }])->ordered()->get();

        return view('instructor.lessons.index', [
            'course' => $course,
            'sections' => $sections,
        ]);
    }

    /**
     * Show the form for creating a new lesson or section.
     */
    public function create(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        return view('instructor.lessons.create', [
            'course' => $course,
            'sections' => $this->availableSections($course),
            'nextOrder' => $this->nextOrderNumber($course, $request->input('parent_id')),
        ]);
    }

    /**
     * Store a newly created lesson.
     */
    public function store(LessonRequest $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        $data = $this->prepareLessonPayload($request, $course);
        $lesson = $course->lessons()->create($data);

        if ($lesson->is_section) {
            return redirect()
                ->route('instructor.lessons.index', $course)
                ->with('status', 'Bagian baru telah ditambahkan.');
        }

        return redirect()
            ->route('instructor.lessons.index', $course)
            ->with('status', 'Materi baru berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Request $request, Course $course, Lesson $lesson)
    {
        $this->authorizeCourse($request, $course);
        $this->ensureOwnership($course, $lesson);

        return view('instructor.lessons.edit', [
            'course' => $course,
            'lesson' => $lesson,
            'sections' => $this->availableSections($course, $lesson),
            'nextOrder' => $this->nextOrderNumber($course, $lesson->parent_id),
        ]);
    }

    /**
     * Update the specified lesson.
     */
    public function update(LessonRequest $request, Course $course, Lesson $lesson)
    {
        $this->authorizeCourse($request, $course);
        $this->ensureOwnership($course, $lesson);

        $data = $this->prepareLessonPayload($request, $course, $lesson);
        $lesson->fill($data);
        $lesson->save();

        return redirect()
            ->route('instructor.lessons.index', $course)
            ->with('status', 'Perubahan materi telah disimpan.');
    }

    /**
     * Remove the specified lesson.
     */
    public function destroy(Request $request, Course $course, Lesson $lesson)
    {
        $this->authorizeCourse($request, $course);
        $this->ensureOwnership($course, $lesson);

        $lesson->delete();

        return redirect()
            ->route('instructor.lessons.index', $course)
            ->with('status', 'Materi berhasil dihapus.');
    }

    /**
     * Ensure the authenticated instructor owns the course.
     */
    private function authorizeCourse(Request $request, Course $course): void
    {
        if ($course->instructor_id !== $request->user()->user_id) {
            abort(403);
        }
    }

    /**
     * Ensure the lesson belongs to the course.
     */
    private function ensureOwnership(Course $course, Lesson $lesson): void
    {
        if ($lesson->course_id !== $course->course_id) {
            abort(404);
        }
    }

    /**
     * Prepare lesson payload from the request.
     */
    private function prepareLessonPayload(LessonRequest $request, Course $course, ?Lesson $lesson = null): array
    {
        $data = $request->validated();

        $isSection = $data['is_section'] ?? false;
        if ($isSection) {
            $data['youtube_link'] = null;
            $data['duration'] = null;
            $data['is_free'] = false;
            $data['parent_id'] = null;
        } else {
            $data['parent_id'] = $data['parent_id'] ?? $request->input('parent_id');
            $data['is_free'] = $data['is_free'] ?? false;
        }

        if (! isset($data['order_number']) || $data['order_number'] === null) {
            $data['order_number'] = $this->nextOrderNumber($course, $data['parent_id'] ?? null);
        }

        return Arr::only($data, [
            'title',
            'parent_id',
            'youtube_link',
            'duration',
            'order_number',
            'is_section',
            'is_free',
        ]);
    }

    /**
     * Get selectable sections for a course, excluding the current lesson if provided.
     */
    private function availableSections(Course $course, ?Lesson $current = null)
    {
        $query = $course->sections()->ordered();

        if ($current) {
            $query->where('lesson_id', '!=', $current->lesson_id);
        }

        return $query->get();
    }

    /**
     * Determine the next order number within a context.
     */
    private function nextOrderNumber(Course $course, $parentId = null): int
    {
        $builder = $course->lessons()->where('parent_id', $parentId);

        $maxOrder = $builder->max('order_number');

        return $maxOrder ? $maxOrder + 1 : 1;
    }
}
