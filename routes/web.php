<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PaymentActionController;
use App\Http\Controllers\Admin\SalesPerformanceController;
use App\Http\Controllers\Admin\TransactionVerificationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\LessonController as InstructorLessonController;
use App\Http\Controllers\Student\CourseEnrollmentController;
use App\Http\Controllers\Student\CourseListController;
use App\Http\Controllers\Student\CourseViewController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\CourseCatalogController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Public Courses
Route::get('/courses', [CourseCatalogController::class, 'index'])->name('courses.index');

// Dashboard Routes - Unified for all roles
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Main Dashboard (redirects based on role)
    Route::get('/', function (Request $request) {
        $user = $request->user();
        if ($user->isAdmin()) {
            return app(AdminDashboardController::class)($request);
        } elseif ($user->isInstructor()) {
            return redirect()->route('dashboard.courses.index');
        } elseif ($user->isStudent()) {
            return app(StudentDashboardController::class)($request);
        }
        abort(403);
    })->name('index');

    // Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.role.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

        Route::get('/sales', [SalesPerformanceController::class, 'index'])->name('sales.index');
        Route::get('/sales/export', [SalesPerformanceController::class, 'export'])->name('sales.export');

        Route::get('/transactions', [TransactionVerificationController::class, 'index'])->name('transactions.index');
        Route::post('/payments/{payment}/verify', [PaymentActionController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/{payment}/clarify', [PaymentActionController::class, 'requestClarification'])->name('payments.clarify');
        Route::post('/payments/{payment}/reject', [PaymentActionController::class, 'reject'])->name('payments.reject');
        Route::post('/payments/bulk-complete', [PaymentActionController::class, 'bulkComplete'])->name('payments.bulk-complete');

        Route::resource('blogs', AdminBlogController::class)->except(['show']);
    });

    // Instructor Routes
    Route::middleware(['instructor'])->group(function () {
        Route::get('/courses', [InstructorCourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [InstructorCourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [InstructorCourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [InstructorCourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [InstructorCourseController::class, 'destroy'])->name('courses.destroy');

        Route::get('/courses/{course}/lessons', [InstructorLessonController::class, 'index'])->name('courses.lessons.index');
        Route::get('/courses/{course}/lessons/create', [InstructorLessonController::class, 'create'])->name('courses.lessons.create');
        Route::post('/courses/{course}/lessons', [InstructorLessonController::class, 'store'])->name('courses.lessons.store');
        Route::get('/courses/{course}/lessons/{lesson}/edit', [InstructorLessonController::class, 'edit'])->name('courses.lessons.edit');
        Route::put('/courses/{course}/lessons/{lesson}', [InstructorLessonController::class, 'update'])->name('courses.lessons.update');
        Route::delete('/courses/{course}/lessons/{lesson}', [InstructorLessonController::class, 'destroy'])->name('courses.lessons.destroy');
    });

    // Student Routes
    Route::middleware(['student'])->group(function () {
        Route::get('/my-courses', [CourseListController::class, 'index'])->name('my-courses.index');
        Route::post('/my-courses/{course}/enroll', [CourseEnrollmentController::class, 'store'])->name('my-courses.enroll');
        Route::get('/my-courses/{course}/learn', [CourseViewController::class, 'show'])->name('my-courses.learn');
        Route::post('/my-courses/{course}/learn/lesson/{lesson}/complete', [CourseViewController::class, 'markComplete'])->name('my-courses.lesson.complete');
    });
});
