<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    // TAMBAHKAN INI
    protected $fillable = [
        'user_id',
        'course_id',
    ];
}
