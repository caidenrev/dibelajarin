<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Ambil 10 pengguna dengan peran 'student', urutkan berdasarkan XP tertinggi
        $topStudents = User::where('role', 'student')
                            ->orderBy('xp', 'desc')
                            ->take(10)
                            ->get();

        return view('leaderboard.index', compact('topStudents'));
    }
}
