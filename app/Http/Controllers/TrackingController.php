<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingSession;
use App\Models\MeetingBooking;

class TrackingController extends Controller
{
    public function index()
    {
        return view('public.tracking.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'tracking_code' => 'required|string',
        ]);

        $code = strtoupper($request->tracking_code);

        // Check in Counseling
        $counseling = CounselingSession::where('tracking_code', $code)->first();
        if ($counseling) {
            return redirect()->route('tracking.show', ['code' => $code]);
        }

        // Check in Booking
        $booking = MeetingBooking::where('tracking_code', $code)->first();
        if ($booking) {
            return redirect()->route('tracking.show', ['code' => $code]);
        }

        return back()->withErrors(['tracking_code' => 'Kode tracking tidak ditemukan. Mohon periksa kembali.']);
    }

    public function show($code)
    {
        $code = strtoupper($code);

        $counseling = CounselingSession::where('tracking_code', $code)->first();
        if ($counseling) {
            return view('public.tracking.result', [
                'data' => $counseling,
                'type' => 'counseling'
            ]);
        }

        $booking = MeetingBooking::where('tracking_code', $code)->with('schedule')->first();
        if ($booking) {
            return view('public.tracking.result', [
                'data' => $booking,
                'type' => 'meeting'
            ]);
        }

        return redirect()->route('tracking.index')->withErrors(['tracking_code' => 'Kode tracking tidak ditemukan.']);
    }
}
