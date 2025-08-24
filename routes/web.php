<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CoursePageController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\InstructorProfileController;
use App\Http\Controllers\QuizPageController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\CommentController;

// <-- TAMBAHKAN BARIS INI DI SINI
Route::get('/admin/login', fn() => redirect()->route('login'))->name('filament.admin.auth.login');

Route::get('/', [LandingPageController::class, 'index'])->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/courses', [CoursePageController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CoursePageController::class, 'show'])->name('courses.show');

Route::get('/instructors/{user}', [InstructorProfileController::class, 'show'])->name('instructors.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonPageController::class, 'show'])->name('lessons.show');

    Route::post('/lessons/{lesson}/complete', [LessonPageController::class, 'complete'])->name('lessons.complete');
    Route::get('/lessons/{lesson}/quiz',[QuizPageController::class, 'show'])->name('quizzes.show');
    Route::post('/lessons/{lesson}/quiz', [QuizPageController::class, 'submit'])->name('quizzes.submit');
    Route::post('/lessons/{lesson}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/quiz-attempts/{attempt}', [QuizAttemptController::class, 'show'])->name('quizzes.result');
});

Route::get('/debug-config', function () {
    // Hentikan eksekusi dan tampilkan output debugging hadeh
    dd([
        'Config App URL' => config('app.url'),
        'URL Helper Generated' => url('/'),
        'Request Scheme' => request()->getScheme(),
        'Request isSecure' => request()->isSecure(),
        'SERVER HTTP_X_FORWARDED_PROTO' => $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'Tidak Ditemukan',
        'SERVER REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'] ?? 'Tidak Ditemukan',
    ]);
});

require __DIR__.'/auth.php';
