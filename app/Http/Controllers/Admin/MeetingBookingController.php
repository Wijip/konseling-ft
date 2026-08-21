<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MeetingBooking;
use Illuminate\Http\Request;

class MeetingBookingController extends Controller
{
    /**
     * Export data to Excel or PDF
     */
    public function export(Request $request)
    {
        MeetingBooking::autoCompleteStatuses();

        $query = MeetingBooking::with('schedule');

        if ($request->filled('konselor')) {
            $query->whereHas('schedule', function ($q) use ($request) {
                $q->where('konselor_name', $request->konselor);
            });
        }

        if ($request->filled('tipe')) {
            $query->where('meeting_type', $request->tipe);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->latest();

        // 1. Cek format unduhan dari parameter query (?format=pdf atau ?format=excel)
        if ($request->get('format') === 'pdf') {
            $bookings = $query->get();
            
            // Render view khusus PDF dan download
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.bookings.pdf', compact('bookings'));
            return $pdf->download('data_booking_pertemuan_' . now()->format('Ymd_His') . '.pdf');
        }

        // 2. Default: Export ke Excel
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\BookingExport($query), 'data_booking_pertemuan.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Auto-complete statuses before displaying
        MeetingBooking::autoCompleteStatuses();

        $query = MeetingBooking::with('schedule');

        // Filter by konselor name (via schedule relationship)
        if ($request->filled('konselor')) {
            $query->whereHas('schedule', function ($q) use ($request) {
                $q->where('konselor_name', $request->konselor);
            });
        }

        // Filter by meeting type
        if ($request->filled('tipe')) {
            $query->where('meeting_type', $request->tipe);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        // Get distinct konselor names for filter dropdown
        $konselorList = \App\Models\MeetingSchedule::distinct()->pluck('konselor_name')->filter()->sort()->values();

        return view('admin.bookings.index', compact('bookings', 'konselorList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = MeetingBooking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $booking->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        // Decrement booked_slots when a booking is rejected
        if ($request->status === 'rejected' && $booking->wasChanged('status')) {
            $booking->schedule->decrement('booked_slots');
        }

        // Send Email Notification if status changed to approved or rejected
        if ($booking->email && in_array($request->status, ['approved', 'rejected'])) {
            try {
                \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\MeetingStatusMail($booking));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Illuminate\Support\Facades\Log::error('Failed to send meeting status email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Status booking diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}