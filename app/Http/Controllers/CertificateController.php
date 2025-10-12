<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Progress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Import PDF Facade

class CertificateController extends Controller
{
    /**
     * Generate a certificate for the given course if the user has completed it.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function generate(Course $course)
    {
        $user = Auth::user();

        // --- Logika Keamanan ---
        // 1. Cek apakah user terdaftar di kursus ini
        // Menggunakan relasi untuk memeriksa enrollment lebih efisien.
        if (! $user->enrolledCourses()->where('course_id', $course->id)->exists()) {
            abort(403, 'Anda tidak terdaftar di kursus ini.');
        }

        // 2. Cek apakah user sudah menyelesaikan 100% pelajaran
        // Menggunakan relasi untuk konsistensi dan menghindari masalah floating point.
        $totalLessons = $course->lessons()->count();
        $completedLessonsCount = $user->completedLessons()
                                     ->where('course_id', $course->id)
                                     ->count();

        // Bandingkan jumlahnya secara langsung untuk menghindari masalah presisi floating point
        // dan pastikan ada pelajaran di kursus tersebut untuk bisa mengunduh sertifikat.
        if ($totalLessons === 0 || $completedLessonsCount < $totalLessons) {
            abort(403, 'Anda harus menyelesaikan semua pelajaran terlebih dahulu.');
        }
        // --- Akhir Logika Keamanan ---

        // --- [BARU] Konversi gambar ke Base64 ---
        $path = public_path('images/mockup-sertifikat.png');
        
        // Check if file exists
        if (!file_exists($path)) {
            abort(500, 'Template sertifikat tidak ditemukan di server. Silakan hubungi administrator.');
        }
        
        try {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $imgData = file_get_contents($path);
            $imageBase64 = 'data:image/' . $type . ';base64,' . base64_encode($imgData);
        } catch (\Exception $e) {
            abort(500, 'Gagal memuat template sertifikat: ' . $e->getMessage());
        }

        // Data yang akan dikirim ke view sertifikat
        $data = [
            'studentName'       => $user->name,
            'courseTitle'       => $course->title,
            'completionDate' => now()->format('d F Y'), // Format tanggal dalam Bahasa Indonesia
            'instructorName'    => $course->instructor->name ?? 'Penyelenggara Kursus',
            'certificateNumber' => 'CERT-' . $course->id . '-' . $user->id . '-' . now()->timestamp,
            'backgroundImage'   => $imageBase64, // Kirim data gambar ke view
        ];

        // Buat PDF dari view Blade dengan orientasi landscape
        try {
            // Set memory limit untuk memproses gambar besar
            ini_set('memory_limit', '256M');
            
            $pdf = Pdf::loadView('certificates.template', $data)
                ->setPaper('a4', 'landscape')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

            // Buat nama file yang lebih rapi
            $fileName = 'Sertifikat - ' . Str::slug($course->title) . '.pdf';
            
            // Download PDF
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            abort(500, 'Gagal membuat PDF sertifikat: ' . $e->getMessage());
        }
    }
}
