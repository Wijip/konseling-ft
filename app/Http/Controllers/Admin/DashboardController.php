<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingSession;
use App\Models\MeetingBooking;
use App\Models\MeetingSchedule;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-complete booking statuses before stats
        MeetingBooking::autoCompleteStatuses();

        // Stats
        $totalCounseling = CounselingSession::count();
        $activeCounseling = CounselingSession::where('status', '!=', 'completed')->count();
        $totalBooking = MeetingBooking::count();
        $upcomingBooking = MeetingBooking::where('status', 'approved')->count();

        // Recent 5
        $recentCounselings = CounselingSession::latest()->take(5)->get();
        $recentBookings = MeetingBooking::with('schedule')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalCounseling',
            'activeCounseling',
            'totalBooking',
            'upcomingBooking',
            'recentCounselings',
            'recentBookings'
        ));
    }
}
