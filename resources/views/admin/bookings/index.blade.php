@extends('admin.layouts.app')

@section('title', 'Daftar Booking Pertemuan')

@section('content')
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
        
        <!-- Header & Filters Section -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h3 class="font-extrabold text-lg sm:text-xl text-slate-900">Semua Permintaan Booking</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Validasi dan kelola permintaan pertemuan tatap muka atau daring.</p>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap">
                <form method="GET" action="{{ route('admin.bookings.index') }}" id="filterForm"
                    class="flex items-center gap-2.5 flex-wrap">
                    
                    {{-- Filter Label --}}
                    <div class="flex items-center gap-1.5 text-slate-500 text-xs font-bold uppercase tracking-wider">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter
                    </div>

                    {{-- Konselor Select --}}
                    <div class="relative inline-flex items-center">
                        <select name="konselor" onchange="this.form.submit()" 
                            class="px-3.5 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] cursor-pointer shadow-xs transition-all appearance-none pr-8">
                            <option value="">Semua Konselor</option>
                            @foreach($konselorList as $konselor)
                                <option value="{{ $konselor }}" {{ request('konselor') == $konselor ? 'selected' : '' }}>
                                    {{ $konselor }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 text-slate-400 absolute right-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    {{-- Tipe Select --}}
                    <div class="relative inline-flex items-center">
                        <select name="tipe" onchange="this.form.submit()" 
                            class="px-3.5 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] cursor-pointer shadow-xs transition-all appearance-none pr-8">
                            <option value="">Semua Tipe</option>
                            <option value="online" {{ request('tipe') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ request('tipe') == 'offline' ? 'selected' : '' }}>Langsung</option>
                        </select>
                        <svg class="w-4 h-4 text-slate-400 absolute right-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    {{-- Status Select --}}
                    <div class="relative inline-flex items-center">
                        <select name="status" onchange="this.form.submit()" 
                            class="px-3.5 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] cursor-pointer shadow-xs transition-all appearance-none pr-8">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <svg class="w-4 h-4 text-slate-400 absolute right-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    {{-- Reset Button --}}
                    @if(request('konselor') || request('tipe') || request('status'))
                        <a href="{{ route('admin.bookings.index') }}"
                            class="inline-flex items-center gap-1 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Dropdown Export Button --}}
                <div x-data="{ openExport: false }" class="relative inline-block text-left" @click.outside="openExport = false">
                    <button type="button" @click="openExport = !openExport"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-white bg-[#064e3b] hover:bg-[#043e2f] border border-[#043e2f] rounded-xl cursor-pointer transition-colors shadow-xs">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export Data
                        <svg class="w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': openExport }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Menu Pilihan Export --}}
                    <div x-show="openExport" 
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-40 bg-white border border-slate-100 rounded-xl shadow-lg z-50 overflow-hidden py-1">
                        
                        {{-- Opsi 1: Excel --}}
                        <a href="{{ route('admin.bookings.export', array_merge(request()->query(), ['format' => 'excel'])) }}"
                            class="flex items-center gap-2 px-3.5 py-2.5 text-xs font-bold text-emerald-600 hover:bg-emerald-50 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>
                            </svg>
                            Export Excel
                        </a>

                        {{-- Opsi 2: PDF --}}
                        <a href="{{ route('admin.bookings.export', array_merge(request()->query(), ['format' => 'pdf'])) }}"
                            class="flex items-center gap-2 px-3.5 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 border-t border-slate-100 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/>
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-4 whitespace-nowrap">Kode Tracking</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Tipe</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Jadwal Diminta</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Konselor</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Nama</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Jabatan</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Divisi</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Tujuan</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-4 whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-[#064e3b] bg-emerald-50 px-2 py-1 rounded-md text-xs border border-emerald-100">
                                    {{ $booking->tracking_code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($booking->meeting_type == 'online')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-100 text-indigo-700">Online</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">Langsung</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs">
                                <div class="font-bold text-slate-900">{{ $booking->schedule->schedule_date->format('d M Y') }}</div>
                                <div class="text-slate-400 text-[11px] font-mono mt-0.5">
                                    {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs font-medium text-slate-800">
                                {{ $booking->schedule->konselor_name ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-slate-900">
                                {{ $booking->name }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600">
                                {{ $booking->jabatan }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600">
                                {{ $booking->division }}
                            </td>
                            <td class="py-3.5 px-4 min-w-[200px] max-w-[280px]">
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed" title="{{ $booking->purpose }}">
                                    {{ $booking->purpose }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold
                                    @if($booking->status == 'pending') bg-amber-100 text-amber-700
                                    @elseif($booking->status == 'approved') bg-emerald-100 text-[#064e3b]
                                    @elseif($booking->status == 'completed') bg-indigo-100 text-indigo-700
                                    @elseif($booking->status == 'rejected') bg-red-100 text-red-700
                                    @else bg-slate-100 text-slate-600
                                    @endif">
                                    @if($booking->status == 'pending') Pending
                                    @elseif($booking->status == 'approved') Disetujui
                                    @elseif($booking->status == 'completed') Selesai
                                    @elseif($booking->status == 'rejected') Ditolak
                                    @else {{ ucfirst($booking->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                <div x-data="{ open: false }">
                                    {{-- Trigger Button --}}
                                    <button @click="open = true" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:border-[#064e3b] text-slate-700 hover:text-[#064e3b] hover:bg-emerald-50/50 rounded-xl text-xs font-bold transition-all shadow-xs cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Update</span>
                                    </button>

                                    {{-- Modal Overlay Teleported --}}
                                    <template x-teleport="body">
                                        <div x-show="open" 
                                            x-cloak
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0" 
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100" 
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4" 
                                            @click.self="open = false"
                                            @keydown.escape.window="open = false">

                                            {{-- Modal Card --}}
                                            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-100" @click.stop>
                                                {{-- Header --}}
                                                <div class="bg-gradient-to-r from-[#064e3b] to-[#043e2f] p-5 text-white">
                                                    <h4 class="text-base sm:text-lg font-extrabold leading-tight">Update Status Booking</h4>
                                                    <p class="text-xs text-white/80 font-mono mt-0.5">{{ $booking->tracking_code }}</p>
                                                </div>

                                                {{-- Body --}}
                                                <div class="p-5 sm:p-6 space-y-4">
                                                    {{-- User Info Summary --}}
                                                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                                        <div class="w-10 h-10 rounded-full bg-[#064e3b] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                                            {{ strtoupper(substr($booking->name, 0, 1)) }}
                                                        </div>
                                                        <div class="min-w-0 flex-1">
                                                            <div class="font-bold text-slate-900 text-sm truncate">{{ $booking->name }}</div>
                                                            <div class="text-xs text-slate-500 truncate">{{ $booking->jabatan }} &bull; {{ $booking->division }}</div>
                                                            <div class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $booking->schedule->schedule_date->format('d M Y') }}</div>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-4">
                                                        @csrf
                                                        @method('PUT')

                                                        {{-- Status Select --}}
                                                        <div>
                                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Booking</label>
                                                            <select name="status" class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all cursor-pointer">
                                                                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                                                                <option value="rejected">❌ Ditolak</option>
                                                            </select>
                                                            @if($booking->status == 'completed')
                                                                <p class="text-xs text-slate-500 mt-1.5 font-medium">
                                                                    ⚠️ Booking ini sudah berstatus <strong class="text-slate-800">Selesai</strong> dan tidak dapat diubah.
                                                                </p>
                                                            @endif
                                                        </div>

                                                        {{-- Admin Notes --}}
                                                        <div>
                                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Balasan / Catatan</label>
                                                            <textarea name="admin_notes"
                                                                placeholder="Tulis balasan atau catatan untuk pemohon..."
                                                                rows="3"
                                                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all placeholder-slate-400 resize-y min-h-[80px]">{{ $booking->admin_notes }}</textarea>
                                                        </div>

                                                        {{-- Action Buttons --}}
                                                        <div class="flex items-center gap-3 pt-2">
                                                            <button type="button" 
                                                                class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs sm:text-sm font-bold transition-colors cursor-pointer"
                                                                @click="open = false">
                                                                Batal
                                                            </button>
                                                            <button type="submit" 
                                                                class="flex-1 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md hover:shadow-lg cursor-pointer">
                                                                Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-12 text-slate-400 text-sm">
                                Belum ada booking masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $schedules->links ?? $bookings->links() }}
        </div>
    </div>
@endsection