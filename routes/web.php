<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PaymentActionController;
use App\Http\Controllers\Admin\SalesPerformanceController;
use App\Http\Controllers\Admin\TransactionVerificationController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users');
    Route::post('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('/sales', [SalesPerformanceController::class, 'index'])->name('sales');
    Route::get('/sales/export', [SalesPerformanceController::class, 'export'])->name('sales.export');
    Route::get('/transactions', [TransactionVerificationController::class, 'index'])->name('transactions');

    Route::post('/payments/{payment}/verify', [PaymentActionController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/clarify', [PaymentActionController::class, 'requestClarification'])->name('payments.clarify');
    Route::post('/payments/{payment}/reject', [PaymentActionController::class, 'reject'])->name('payments.reject');
    Route::post('/payments/bulk-complete', [PaymentActionController::class, 'bulkComplete'])->name('payments.bulk-complete');
    Route::resource('blogs', AdminBlogController::class);
});

// Courses
Route::get('/courses', function () {
    return view('courses.index');
})->name('courses.index');

Route::get('/courses/{id}', function ($id) {
    return view('courses.show');
})->name('courses.show');

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
