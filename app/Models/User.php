<?php

namespace App\Models;

// PASTIKAN KEDUANYA ADA
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
// ==========================

use App\Notifications\VerifyEmail as VerifyEmailNotification;
// Hapus 'use Illuminate\Contracts\Auth\MustVerifyEmail;' karena tidak lagi digunakan
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Hapus 'MustVerifyEmail' dari baris implements
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'xp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ... (method relasi Anda yang lain seperti courses(), enrolledCourses(), dll. biarkan saja) ...
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')->withTimestamps();
    }
    public function completedLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'progress', 'user_id', 'lesson_id')->withTimestamps();
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // ==========================================================
    // METHOD UNTUK MEMBERI IZIN AKSES KE FILAMENT
    // ==========================================================
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin' || $this->role === 'instructor';
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        // Fungsi ini bisa dikosongkan atau biarkan saja, karena tidak akan dipanggil lagi
        // $this->notify(new VerifyEmailNotification);
    }

    /**
     * Menentukan apakah user sudah memverifikasi alamat email mereka.
     * Diubah agar selalu mengembalikan true.
     *
     * @return bool
     */
    public function hasVerifiedEmail(): bool
    {
        // Langsung kembalikan true agar semua user dianggap terverifikasi
        return true;
    }
}
