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

// Route untuk admin login
Route::get('/admin/login', fn() => redirect()->route('login'))->name('filament.admin.auth.login');

// Grup untuk semua route yang akan menggunakan middleware redirect.if.admin
Route::middleware(['redirect.if.admin'])->group(function () {
    // Route publik
    Route::get('/', [LandingPageController::class, 'index'])->name('welcome');
    Route::get('/about', function () {
        return view('about');
    })->name('about');
    Route::get('/courses', [CoursePageController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CoursePageController::class, 'show'])->name('courses.show');
    Route::get('/instructors/{user}', [InstructorProfileController::class, 'show'])->name('instructors.show');

    // Route yang memerlukan autentikasi
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
});



require __DIR__.'/auth.php';
