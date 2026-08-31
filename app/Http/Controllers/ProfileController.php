<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user
     */
    public function show()
    {
        $user = auth()->user();

        // Hitung statistik untuk ditampilkan di profil
        $totalChat = $user->counselingSessions()->count();
        $totalMeetings = $user->meetingBookings()->count();
        $totalCounseling = $totalChat + $totalMeetings;

        return view('public.profile', compact(
            'user',
            'totalChat',
            'totalMeetings',
            'totalCounseling'
        ));
    }
}