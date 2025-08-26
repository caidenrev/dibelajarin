<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Import PDF Facade

class CertificateController extends Controller
{
    public function generate(Course $course)
    {
        $user = Auth::user();

        // --- Logika Keamanan ---
        // 1. Cek apakah user terdaftar di kursus ini
        if (! $user->enrolledCourses->contains($course)) {
            abort(403, 'Anda tidak terdaftar di kursus ini.');
        }

        // 2. Cek apakah user sudah menyelesaikan 100% pelajaran
        $totalLessons = $course->lessons->count();
        $completedLessons = $user->completedLessons->where('course_id', $course->id)->count();
        $progress = ($totalLessons > 0) ? ($completedLessons / $totalLessons) * 100 : 0;

        if ($progress < 100) {
            abort(403, 'Anda harus menyelesaikan semua pelajaran terlebih dahulu.');
        }
        // --- Akhir Logika Keamanan ---

        // Data yang akan dikirim ke view sertifikat
        $data = [
            'studentName' => $user->name,
            'courseTitle' => $course->title,
            'completionDate' => now()->format('d F Y'),
        ];

        // Buat PDF dari view Blade
        $pdf = Pdf::loadView('certificates.template', $data)->setPaper('a4', 'landscape');

        // Download PDF
        $fileName = 'Sertifikat - ' . Str::slug($course->title) . '.pdf';
        return $pdf->download($fileName);
    }
}
