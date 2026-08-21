<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MeetingSchedule;
use Illuminate\Http\Request;

class MeetingScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = MeetingSchedule::latest('schedule_date')->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $konselors = \App\Models\User::where('role', 'konselor')->get();
        return view('admin.schedules.create', compact('konselors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'konselor_name' => 'required|string|max:255',
            'rumpun'        => 'nullable|string|max:255', // Validasi kolom rumpun
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'max_slots'     => 'required|integer|min:1|max:10',
        ]);

        MeetingSchedule::create([
            'konselor_name' => $request->konselor_name,
            'rumpun'        => $request->rumpun, // Menimpan data rumpun
            'schedule_date' => $request->schedule_date,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
            'max_slots'     => $request->max_slots,
            'is_available'  => true,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
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
        // Toggle availability
        $schedule = MeetingSchedule::findOrFail($id);
        $schedule->update([
            'is_available' => !$schedule->is_available,
        ]);

        return back()->with('success', 'Status ketersediaan diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = MeetingSchedule::findOrFail($id);

        if ($schedule->bookings()->count() > 0) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus jadwal yang sudah memiliki booking.']);
        }

        $schedule->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }
}