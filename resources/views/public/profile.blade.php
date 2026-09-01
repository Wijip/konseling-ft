@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50 min-h-[calc(100vh-160px)]">
    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Profile Card Header & Details -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5 pb-6 mb-6 border-b border-gray-100">
                {{-- Avatar Initial --}}
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#064e3b] text-white flex items-center justify-center text-2xl sm:text-3xl font-extrabold shadow-md shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-1">{{ $user->name }}</h1>
                    <p class="text-gray-500 text-sm sm:text-base">{{ $user->email }}</p>
                    <span class="inline-block mt-2.5 bg-emerald-100 text-[#064e3b] px-3 py-1 rounded-full font-bold text-xs">
                        {{ ucfirst($user->role ?? 'Pengguna') }}
                    </span>
                </div>
            </div>

            <!-- Account Detail Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-100">
                    <span class="text-xs text-gray-500 block mb-1">Terdaftar Sejak</span>
                    <strong class="text-gray-900 text-sm sm:text-base font-bold">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</strong>
                </div>
                <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-100">
                    <span class="text-xs text-gray-500 block mb-1">Total Aktivitas Konseling</span>
                    <strong class="text-[#064e3b] text-sm sm:text-base font-bold">{{ $totalCounseling }} Kali Konsultasi</strong>
                </div>
            </div>
        </div>

        <!-- Activity Summary Section -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-base sm:text-lg font-extrabold text-gray-900 mb-4">Ringkasan Konseling</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="border border-gray-100 p-4 rounded-xl bg-white shadow-xs">
                    <span class="text-xs sm:text-sm text-gray-500 font-medium">Konseling Chat Online</span>
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ $totalChat }}</div>
                </div>
                <div class="border border-gray-100 p-4 rounded-xl bg-white shadow-xs">
                    <span class="text-xs sm:text-sm text-gray-500 font-medium">Booking Pertemuan</span>
                    <div class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ $totalMeetings }}</div>
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('history') }}" 
                    class="inline-flex items-center gap-2 px-5 py-3 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl font-bold text-xs sm:text-sm transition-all shadow-md hover:shadow-lg">
                    <span>Lihat Seluruh Riwayat Konseling</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection