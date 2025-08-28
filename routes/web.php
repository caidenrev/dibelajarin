<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LeaderboardController;

// <-- TAMBAHKAN BARIS INI DI SINI
Route::get('/admin/login', fn() => redirect()->route('login'))->name('filament.admin.auth.login');

Route::get('/', [LandingPageController::class, 'index'])->name('welcome');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/courses', [CoursePageController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CoursePageController::class, 'show'])->name('courses.show');

Route::get('/instructors/{user}', [InstructorProfileController::class, 'show'])->name('instructors.show');

// Middleware 'verified' telah dihapus dari baris di bawah ini
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::get('/check-storage', function () {
    try {
        $files = Storage::disk('public')->files('course-thumbnails');

        if (empty($files)) {
            return response()->json([
                'status' => 'success',
                'directory_exists' => Storage::disk('public')->exists('course-thumbnails'),
                'message' => 'Direktori ditemukan tetapi kosong.',
                'files' => []
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'File ditemukan.',
            'files' => $files
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi error saat mengakses storage: ' . $e->getMessage()
        ], 500);
    }
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonPageController::class, 'show'])->name('lessons.show');
    Route::get('/courses/{course}/certificate', [CertificateController::class, 'generate'])->name('courses.certificate');

    Route::post('/lessons/{lesson}/complete', [LessonPageController::class, 'complete'])->name('lessons.complete');
    Route::get('/lessons/{lesson}/quiz',[QuizPageController::class, 'show'])->name('quizzes.show');
    Route::post('/lessons/{lesson}/quiz', [QuizPageController::class, 'submit'])->name('quizzes.submit');
    Route::post('/lessons/{lesson}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/quiz-attempts/{attempt}', [QuizAttemptController::class, 'show'])->name('quizzes.result');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
});



require __DIR__.'/auth.php';
