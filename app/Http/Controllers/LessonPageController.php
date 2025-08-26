<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonPageController extends Controller
{
    // app/Http/Controllers/LessonPageController.php

    public function show(Course $course, Lesson $lesson)
    {
        $user = Auth::user();

        // --- LOGIKA KEAMANAN BARU ---
        $isEnrolled = $user->enrolledCourses->contains($course);
        $isInstructor = $course->user_id === $user->id;

        // Cek apakah pelajaran ini memang milik kursus yang sedang diakses
        $isCorrectLesson = $lesson->course_id == $course->id;

        // Jika user BUKAN siswa terdaftar DAN BUKAN instruktur pemilik, tolak akses.
        if ((!$isEnrolled && !$isInstructor) || !$isCorrectLesson) {
            abort(403, 'Akses Ditolak');
        }
        // --- AKHIR LOGIKA KEAMANAN ---

        $allLessons = $course->lessons()->orderBy('id')->get();
        $lesson->load(['comments' => function ($query) {
        $query->whereNull('parent_id')->with('user', 'replies.user');
        }]);


        return view('lessons.show', [
            'course' => $course,
            'lesson' => $lesson,
            'allLessons' => $allLessons,
        ]);
}

    public function complete(Lesson $lesson)
    {
        $user = Auth::user();

        // Cek keamanan
        if (!$user->enrolledCourses->contains($lesson->course)) {
            abort(403, 'Akses Ditolak');
        }

        // Tandai selesai
        $user->completedLessons()->syncWithoutDetaching([$lesson->id]);

        // TAMBAHKAN BARIS INI: Beri 10 XP
        $user->increment('xp', 10);

        // --- LOGIKA LANJUT OTOMATIS ---
        // 1. Ambil semua pelajaran di kursus ini, urutkan berdasarkan ID
        $allLessons = $lesson->course->lessons()->orderBy('id')->get();

        // 2. Cari tahu "kunci" atau indeks dari pelajaran saat ini
        $currentLessonKey = $allLessons->search(fn($item) => $item->id == $lesson->id);

        // 3. Cek apakah ada pelajaran setelahnya
        if (isset($allLessons[$currentLessonKey + 1])) {
            // Jika ada, ambil pelajaran berikutnya
            $nextLesson = $allLessons[$currentLessonKey + 1];
            // Redirect ke pelajaran berikutnya
            return redirect()->route('lessons.show', [$lesson->course, $nextLesson])
                ->with('success', 'Pelajaran ditandai selesai! Lanjut ke materi berikutnya.');
        }

        // Jika ini adalah pelajaran terakhir, redirect ke dashboard
        return redirect()->route('dashboard')
            ->with('success', 'Selamat! Anda telah menyelesaikan semua pelajaran di kursus ini.');
    }
}
