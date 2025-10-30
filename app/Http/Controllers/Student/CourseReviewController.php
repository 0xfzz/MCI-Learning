<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreReviewRequest;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class CourseReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Course $course): RedirectResponse
    {
        $student = $request->user();

        $enrollment = $student?->enrollments()
            ->where('course_id', $course->course_id)
            ->first();

        if (!$enrollment) {
            return redirect()
                ->route('dashboard.my-courses.index')
                ->withErrors('Anda belum terdaftar di kursus ini.');
        }

        $existingReview = Review::where('user_id', $student->user_id)
            ->where('course_id', $course->course_id)
            ->first();

        if ($existingReview && $existingReview->status === 'approved') {
            return back()->withErrors('Ulasan kamu sudah disetujui dan tidak dapat diperbarui.');
        }

        $payload = [
            'user_id' => $student->user_id,
            'course_id' => $course->course_id,
            'rating' => $request->integer('rating'),
            'comment' => trim($request->input('comment')),
            'status' => 'pending',
            'approved_at' => null,
            'approved_by' => null,
        ];

        Review::updateOrCreate(
            [
                'user_id' => $student->user_id,
                'course_id' => $course->course_id,
            ],
            $payload,
        );

        return back()->with('status', 'Terima kasih! Ulasan kamu sudah dikirim dan menunggu persetujuan admin.');
    }
}
