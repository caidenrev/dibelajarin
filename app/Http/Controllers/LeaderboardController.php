<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'student') // 1. Hanya ambil user dengan role 'student'
                     ->where('xp', '>', 0)       // 2. Hanya ambil yang XP nya lebih dari 0
                     ->orderBy('xp', 'desc')     // 3. Urutkan dari XP tertinggi
                     ->paginate(15);             // 4. Batasi 15 user per halaman (Pagination)

        return view('leaderboard.index', compact('users'));
    }
}
