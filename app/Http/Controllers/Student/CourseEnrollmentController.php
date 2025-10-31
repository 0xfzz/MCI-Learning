<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CourseEnrollmentController extends Controller
{
    /**
     * Handle a course enrollment request.
     */
    public function store(Request $request, Course $course)
    {
        $student = $request->user();

        if (! $student) {
            abort(403);
        }

        if ($student->isInstructor() || $student->isAdmin()) {
            return redirect()
                ->back()
                ->withErrors(['enroll' => 'Hanya siswa yang dapat mendaftar kursus.']);
        }

        if ($student->enrollments()->where('course_id', $course->course_id)->exists()) {
            return redirect()
                ->route('dashboard')
                ->with('status', 'Anda sudah terdaftar di kursus ini.');
        }

        if ($course->isFree()) {
            $request->merge(['payment_method' => 'free']);

            $request->validate([
                'payment_method' => [Rule::in(['free'])],
            ]);

            return $this->enrollFreeCourse($student, $course);
        }

        $request->merge([
            'payment_method' => $request->input('payment_method', 'manual-transfer'),
        ]);

        $request->validate([
            'payment_method' => ['required', Rule::in(['manual-transfer'])],
            'bukti_transfer' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $existingSuccessPayment = $student
            ->payments()
            ->where('course_id', $course->course_id)
            ->where('status', 'success')
            ->first();

        if ($existingSuccessPayment) {
            $existingSuccessPayment->ensureEnrollmentExists();

                return redirect()
                    ->route('dashboard')
                ->with('status', 'Pembayaran Anda telah diverifikasi. Kursus siap dipelajari.');
        }

        $pendingPayment = $student
            ->payments()
            ->where('course_id', $course->course_id)
            ->where('status', 'pending')
            ->first();

        if ($pendingPayment) {
            $message = $pendingPayment->clarification_requested_at
                ? 'Pembayaran Anda memerlukan klarifikasi. Silakan unggah ulang bukti transfer sesuai arahan admin.'
                : 'Pembayaran Anda sedang diverifikasi. Kami akan mendaftarkan Anda setelah selesai.';

            return redirect()
                ->route('dashboard')
                ->with('status', $message);
        }

        DB::beginTransaction();

        try {
            $paymentData = [
                'course_id' => $course->course_id,
                'amount' => $course->getEffectivePrice() ?? 0,
                'status' => 'pending',
            ];

            // Handle proof of payment upload (required for paid courses)
            $file = $request->file('bukti_transfer');
            $filename = time() . '_' . $student->user_id . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payments', $filename, 'public');
            $paymentData['bukti_transfer'] = $path;

            $student->payments()->create($paymentData);

            DB::commit();

            return redirect()
                ->route('dashboard')
                ->with('status', 'Permintaan pembayaran berhasil dibuat. Bukti transfer telah diunggah dan akan segera diverifikasi.');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error('Failed to create payment for enrollment', [
                'student_id' => $student->user_id,
                'course_id' => $course->course_id,
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withErrors(['enroll' => 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.']);
        }
    }

    private function enrollFreeCourse(User $student, Course $course)
    {
        DB::beginTransaction();

        try {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $student->user_id,
                    'course_id' => $course->course_id,
                ],
                [
                    'enrolled_at' => now(),
                    'is_completed' => false,
                ],
            );

            DB::commit();

            return redirect()
                ->route('dashboard')
                ->with('status', 'Berhasil mendaftar kursus. Selamat belajar!');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::error('Failed to enroll student in free course', [
                'student_id' => $student->user_id,
                'course_id' => $course->course_id,
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withErrors(['enroll' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.']);
        }
    }
}
