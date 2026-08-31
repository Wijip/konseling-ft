<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeetingSchedule;
use App\Models\MeetingBooking;
use Carbon\Carbon;

class MeetingController extends Controller
{
    public function index()
    {
        return redirect()->route('meeting.calendar');
    }

    public function calendar(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $date = $request->get('date', now()->format('Y-m-d'));

        $startDate = Carbon::createFromDate($year, $month, 1);
        $selectedDate = Carbon::parse($date);

        // 1. Ambil semua jadwal dalam bulan ini untuk penanda titik pada tanggal kalender
        $monthlySchedules = MeetingSchedule::whereYear('schedule_date', $year)
            ->whereMonth('schedule_date', $month)
            ->where('is_available', true)
            ->whereRaw('booked_slots < max_slots')
            ->get()
            ->groupBy(function ($item) {
                return $item->schedule_date->format('Y-m-d');
            });

        // 2. Ambil slot jadwal pada tanggal yang dipilih
        // MENGGUNAKAN 'konselor' (sesuai nama fungsi relasi di model MeetingSchedule.php)
        $selectedDateSlots = MeetingSchedule::with(['konselor'])
            ->whereDate('schedule_date', $selectedDate)
            ->where('is_available', true)
            ->whereRaw('booked_slots < max_slots')
            ->orderBy('start_time')
            ->get();

        return view('public.meeting.calendar', [
            'month'             => $month,
            'year'              => $year,
            'startDate'         => $startDate,
            'selectedDate'      => $selectedDate,
            'slots'             => $monthlySchedules,
            'selectedDateSlots' => $selectedDateSlots
        ]);
    }

    public function create(MeetingSchedule $schedule)
    {
        if ($schedule->booked_slots >= $schedule->max_slots || !$schedule->is_available) {
            return redirect()->route('meeting.calendar')->withErrors(['Slot ini sudah penuh atau tidak tersedia.']);
        }

        return view('public.meeting.form', compact('schedule'));
    }

    public function store(Request $request)
    {
        // Validasi input data dari form booking
        $request->validate([
            'meeting_schedule_id' => 'required|exists:meeting_schedules,id',
            'meeting_type'        => 'required|in:offline,online',
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255',
            'phone_number'        => 'required|string|max:20',
            'employee_id'         => 'required|string|max:255',
            'status'              => 'nullable|string|max:255', // Status: Dosen / Karyawan / Mahasiswa
            'rumpun'              => 'nullable|string|max:255', // Rumpun: Informatika / Elektro / Sipil / Mesin / PKK
            'prodi'               => 'nullable|string|max:255',  // Program Studi
            'division'            => 'nullable|string|max:255', // Opsional (jika masih menggunakan division)
            'jabatan'             => 'nullable|string|max:255',  // Opsional (jika masih menggunakan jabatan)
            'purpose'             => 'required|string|max:2000',
        ]);

        $schedule = MeetingSchedule::findOrFail($request->meeting_schedule_id);

        if ($schedule->booked_slots >= $schedule->max_slots) {
            return back()->withErrors(['Slot ini baru saja dipesan orang lain. Silakan pilih slot lain.']);
        }

        $user = auth()->user();

        // Simpan data booking ke database
        $booking = MeetingBooking::create([
            'meeting_schedule_id' => $schedule->id,
            'meeting_type'        => $request->meeting_type,
            'name'                => $request->name,
            'email'               => $request->email ?? ($user ? $user->email : null),
            'phone_number'        => $request->phone_number,
            'employee_id'         => $request->employee_id,
            'status'              => $request->status ?? 'Mahasiswa',
            'rumpun'              => $request->rumpun,
            'prodi'               => $request->prodi,
            'division'            => $request->division ?? $request->rumpun,
            'jabatan'             => $request->jabatan ?? $request->prodi,
            'purpose'             => $request->purpose,
            'booking_status'      => 'pending',
        ]);

        // Tambahkan jumlah slot yang terisi
        $schedule->increment('booked_slots');

        // Redirect ke halaman tracking dengan membawa kode unik
        return redirect()->route('tracking.show', ['code' => $booking->tracking_code])
            ->with('success', 'Booking berhasil diajukan! Simpan kode tracking Anda.');
    }
}