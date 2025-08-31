<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Enrollment;
use App\Models\Progress;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Mengambil data statistik untuk user yang sedang login
        $coursesEnrolled = Enrollment::where('user_id', $user->id)->count();
        $lessonsCompleted = Progress::where('user_id', $user->id)
                                    ->where('completed', true)
                                    ->count();
        $totalXp = $user->xp;

        // Data dummy untuk grafik (karena kita tidak memiliki histori XP harian)
        // Anda bisa mengembangkannya untuk mencatat XP harian di masa depan
        $xpData = json_encode([rand(10, 50), rand(20, 60), rand(30, 70), rand(40, 80), rand(50, 90), rand(60, 100), $totalXp]);
        $lessonsData = json_encode([rand(1, 5), rand(1, 5), rand(2, 6), rand(3, 7), rand(4, 8), rand(5, 9), rand(5, 10)]);
        $coursesData = json_encode([rand(0, 1), rand(0, 2), rand(0, 2), rand(1, 2), rand(1, 3), rand(1, 3), rand(2, 4)]);

        return view('profile.edit', [
            'user' => $user,
            'coursesEnrolled' => $coursesEnrolled,
            'lessonsCompleted' => $lessonsCompleted,
            'totalXp' => $totalXp,
            'xpData' => $xpData,
            'lessonsData' => $lessonsData,
            'coursesData' => $coursesData,
        ]);
    }

    // ... sisa method lainnya tidak perlu diubah
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}