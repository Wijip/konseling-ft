@extends('layouts.app')

@section('title', 'Riwayat Konseling Saya')

@section('content')
<div class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50 min-h-[calc(100vh-160px)]">
    <div class="max-w-7xl mx-auto space-y-8">
        
        <!-- Header Section -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#064e3b]">Riwayat Konseling</h1>
            <p class="text-gray-500 text-sm sm:text-base mt-1">Daftar dan statistik sesi konseling online serta pertemuan yang pernah Anda ajukan.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-xs sm:text-sm font-semibold text-gray-500 block mb-1">Total Konseling</span>
                    <span class="text-3xl sm:text-4xl font-black text-[#064e3b]">{{ $totalCounseling }}</span>
                </div>
                <span class="text-xs text-gray-400 mt-3 block">Kali Konsultasi</span>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-xs sm:text-sm font-semibold text-gray-500 block mb-1">Chat Online</span>
                    <span class="text-3xl sm:text-4xl font-black text-emerald-600">{{ $totalChat }}</span>
                </div>
                <span class="text-xs text-gray-400 mt-3 block">Sesi Terdaftar</span>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="text-xs sm:text-sm font-semibold text-gray-500 block mb-1">Pertemuan (Tatap Muka/Zoom)</span>
                    <span class="text-3xl sm:text-4xl font-black text-amber-600">{{ $totalMeetings }}</span>
                </div>
                <span class="text-xs text-gray-400 mt-3 block">Jadwal Pertemuan</span>
            </div>
        </div>

        <!-- Section Chat Online -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 mb-6 pb-4 border-b border-gray-100 flex items-center gap-2">
                💬 Riwayat Konseling Chat Online
            </h2>

            @if($counselingSessions->isEmpty())
                <p class="text-gray-400 text-sm text-center py-8">Belum ada riwayat sesi konseling chat online.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 border-b border-gray-100">
                                <th class="py-3 px-4 font-bold">Kode Tracking</th>
                                <th class="py-3 px-4 font-bold">Topik Masalah</th>
                                <th class="py-3 px-4 font-bold">Tanggal Pengajuan</th>
                                <th class="py-3 px-4 font-bold">Status</th>
                                <th class="py-3 px-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach($counselingSessions as $session)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#064e3b]">{{ $session->tracking_code }}</td>
                                    <td class="py-3.5 px-4 font-medium">{{ $session->issue_topic ?? 'Umum' }}</td>
                                    <td class="py-3.5 px-4 text-gray-500">{{ $session->created_at->format('d M Y, H:i') }} WIB</td>
                                    <td class="py-3.5 px-4">
                                        @if($session->status === 'pending')
                                            <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">Pending</span>
                                        @elseif($session->status === 'in_progress')
                                            <span class="bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">In Progress</span>
                                        @elseif($session->status === 'completed')
                                            <span class="bg-emerald-100 text-[#064e3b] px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">Selesai</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <a href="{{ route('counseling.chat', $session->tracking_code) }}" 
                                            class="inline-block bg-[#064e3b] hover:bg-[#043e2f] text-white px-3.5 py-1.5 rounded-lg font-bold text-xs transition-colors shadow-sm">
                                            Masuk Chat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Section Booking Pertemuan -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 mb-6 pb-4 border-b border-gray-100 flex items-center gap-2">
                📅 Riwayat Booking Pertemuan
            </h2>

            @if($meetingBookings->isEmpty())
                <p class="text-gray-400 text-sm text-center py-8">Belum ada riwayat booking pertemuan.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 border-b border-gray-100">
                                <th class="py-3 px-4 font-bold">Kode Tracking</th>
                                <th class="py-3 px-4 font-bold">Konselor</th>
                                <th class="py-3 px-4 font-bold">Tipe</th>
                                <th class="py-3 px-4 font-bold">Jadwal Pertemuan</th>
                                <th class="py-3 px-4 font-bold">Status</th>
                                <th class="py-3 px-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach($meetingBookings as $booking)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3.5 px-4 font-mono font-bold text-[#064e3b]">{{ $booking->tracking_code }}</td>
                                    <td class="py-3.5 px-4 font-medium">{{ $booking->schedule->konselor_name ?? '-' }}</td>
                                    <td class="py-3.5 px-4 font-semibold">
                                        @if($booking->meeting_type === 'online')
                                            <span class="text-blue-600">Online (Zoom)</span>
                                        @else
                                            <span class="text-gray-700">Langsung</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-gray-500">
                                        @if($booking->schedule)
                                            {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }} ({{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if($booking->status === 'pending')
                                            <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">Pending</span>
                                        @elseif($booking->status === 'approved')
                                            <span class="bg-emerald-100 text-[#064e3b] px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">Disetujui</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="bg-indigo-100 text-indigo-700 px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">Selesai</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full font-bold text-xs whitespace-nowrap">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <a href="{{ route('tracking.show', $booking->tracking_code) }}" 
                                            class="inline-block bg-gray-900 hover:bg-gray-800 text-white px-3.5 py-1.5 rounded-lg font-bold text-xs transition-colors shadow-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection