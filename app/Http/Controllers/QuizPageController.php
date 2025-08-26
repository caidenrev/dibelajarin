<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizPageController extends Controller
{
    public function show(Lesson $lesson)
    {
        // Eager load kuis beserta pertanyaannya
        $lesson->load('quiz.questions');

        // Cek Keamanan 1: Pastikan pelajaran ini punya kuis
        if (!$lesson->quiz) {
            abort(404, 'Kuis tidak ditemukan.');
        }

        // Cek Keamanan 2: Pastikan user terdaftar di kursus ini
        $isEnrolled = Auth::user()->enrolledCourses->contains($lesson->course);
        if (!$isEnrolled) {
            abort(403, 'Akses Ditolak');
        }

        return view('quizzes.show', [
            'lesson' => $lesson,
            'quiz' => $lesson->quiz,
        ]);
    }

    public function submit(Request $request, Lesson $lesson)
    {
        $quiz = $lesson->quiz()->with('questions')->firstOrFail();
        $answers = $request->input('answers', []);
        $score = 0;

        // Hitung skor
        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $score++;
            }
        }

        // TAMBAHKAN BARIS INI: Beri 15 XP per jawaban benar
        Auth::user()->increment('xp', $score * 15);

        // Simpan hasil percobaan kuis
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $quiz->questions->count(),
        ]);

        // Arahkan ke halaman hasil (akan kita buat selanjutnya)
        return redirect()->route('quizzes.result', $attempt->id);
    }
}
