@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#064e3b] tracking-tight">Dashboard</h1>
        <p class="text-slate-500 text-sm sm:text-base mt-1">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#064e3b] flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Total Konseling Chat</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-900">{{ $totalCounseling }}</p>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100/70 text-emerald-700 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Konseling Chat Aktif</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-900">{{ $activeCounseling }}</p>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Total Booking Pertemuan</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-900">{{ $totalBooking }}</p>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-0.5">Booking Mendatang</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-900">{{ $upcomingBooking }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Items Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        <!-- Recent Counseling Card -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <h2 class="text-base sm:text-lg font-extrabold text-slate-900">Konseling Terbaru</h2>
                <a href="{{ route('admin.counseling.index') }}" class="text-xs sm:text-sm font-bold text-[#064e3b] hover:text-[#043e2f] transition-colors flex items-center gap-1">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="space-y-1">
                @forelse($recentCounselings as $counseling)
                    <a href="{{ route('admin.counseling.show', $counseling->id) }}" class="group flex items-center gap-3.5 p-3 rounded-xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-200/60">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#064e3b] to-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                            {{ strtoupper(substr($counseling->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate group-hover:text-[#064e3b] transition-colors">
                                @if($counseling->identity_type === 'anonymous')
                                    Anonim
                                @else
                                    {{ $counseling->name }}
                                @endif
                            </p>
                            <p class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5">
                                <span class="font-mono font-bold text-[#064e3b]">{{ $counseling->tracking_code }}</span>
                                <span>•</span>
                                <span>{{ $counseling->created_at->diffForHumans() }}</span>
                            </p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold whitespace-nowrap shrink-0
                            @if($counseling->status == 'pending') bg-amber-100 text-amber-700
                            @elseif($counseling->status == 'active') bg-emerald-100 text-[#064e3b]
                            @elseif($counseling->status == 'completed') bg-indigo-100 text-indigo-700
                            @else bg-slate-100 text-slate-600
                            @endif">
                            @if($counseling->status == 'pending') Pending
                            @elseif($counseling->status == 'active') Aktif
                            @elseif($counseling->status == 'completed') Selesai
                            @else {{ ucfirst($counseling->status) }}
                            @endif
                        </span>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#064e3b] group-hover:translate-x-0.5 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-10 text-slate-400 text-sm">
                        <svg class="w-10 h-10 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>Belum ada konseling terbaru</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Bookings Card -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <h2 class="text-base sm:text-lg font-extrabold text-slate-900">Booking Terbaru</h2>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs sm:text-sm font-bold text-[#064e3b] hover:text-[#043e2f] transition-colors flex items-center gap-1">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="space-y-1">
                @forelse($recentBookings as $booking)
                    <a href="{{ route('admin.bookings.index') }}" class="group flex items-center gap-3.5 p-3 rounded-xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-200/60">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-600 to-amber-700 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                            {{ strtoupper(substr($booking->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate group-hover:text-[#064e3b] transition-colors">{{ $booking->name }}</p>
                            <p class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5">
                                <span class="font-mono font-bold text-[#064e3b]">{{ $booking->tracking_code }}</span>
                                <span>•</span>
                                <span>{{ $booking->schedule->schedule_date->format('d M Y') }}</span>
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold inline-block
                                @if($booking->status == 'pending') bg-amber-100 text-amber-700
                                @elseif($booking->status == 'approved') bg-emerald-100 text-[#064e3b]
                                @elseif($booking->status == 'completed') bg-indigo-100 text-indigo-700
                                @else bg-slate-100 text-slate-600
                                @endif">
                                @if($booking->status == 'pending') Pending
                                @elseif($booking->status == 'approved') Disetujui
                                @elseif($booking->status == 'completed') Selesai
                                @else {{ ucfirst($booking->status) }}
                                @endif
                            </span>
                            <p class="text-[10px] text-slate-400 mt-0.5 text-right">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#064e3b] group-hover:translate-x-0.5 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-10 text-slate-400 text-sm">
                        <svg class="w-10 h-10 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Belum ada booking</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection