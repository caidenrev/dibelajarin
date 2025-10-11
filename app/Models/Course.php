<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // PASTIKAN BLOK INI ADA DAN LENGKAP
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'category_id',
        'thumbnail',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($course) {
            // Delete the thumbnail file when the course is deleted
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
        });

        static::creating(function ($course) {
            $course->slug = Str::slug($course->title);
        });
    }

    protected $casts = [
        'thumbnail' => 'string',
        'description' => 'string',
    ];

    protected $appends = ['thumbnail_url'];

    public function getThumbnailUrlAttribute()
    {
        if (!$this->thumbnail) {
            return null;
        }
        
        // Handle URLs that are already absolute
        if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
            return $this->thumbnail;
        }

        // Handle relative paths
        $path = str_replace('public/', '', $this->thumbnail);
        $path = str_replace('//', '/', $path);
        
        if (app()->environment('production')) {
            return secure_asset('storage/' . $path);
        }
        
        return asset('storage/' . $path);
    }

    /**
     * Get the instructor that owns the course.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrolledStudents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')->withTimestamps();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
