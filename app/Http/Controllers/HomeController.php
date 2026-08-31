<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingSession;
use App\Models\MeetingBooking;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.home');
    }

    public function history()
    {
        $user = auth()->user();

        // Cari riwayat chat berdasarkan email
        $counselingSessions = CounselingSession::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();

        // Cari riwayat booking pertemuan berdasarkan email
        $meetingBookings = MeetingBooking::where('email', $user->email)
            ->with('schedule')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalChat = $counselingSessions->count();
        $totalMeetings = $meetingBookings->count();
        $totalCounseling = $totalChat + $totalMeetings;

        return view('public.history', compact(
            'counselingSessions',
            'meetingBookings',
            'totalChat',
            'totalMeetings',
            'totalCounseling'
        ));
    }
}