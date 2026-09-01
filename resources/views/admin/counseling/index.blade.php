@extends('admin.layouts.app')

@section('title', 'Daftar Konseling')

@php
    $topicLabels = [
        'Pekerjaan' => 'Masalah Pekerjaan / Karir',
        'Keluarga' => 'Masalah Keluarga / Pribadi',
        'Hubungan' => 'Hubungan dengan Rekan Kerja',
        'Stress' => 'Stress / Burnout',
        'Lainnya' => 'Lainnya',
    ];
@endphp

@section('content')
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
        
        <!-- Header & Filters Section -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h3 class="font-extrabold text-lg sm:text-xl text-slate-900">Semua Sesi Konseling</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Kelola permintaan konseling chat online dari pengguna.</p>
            </div>

            <form method="GET" action="{{ route('admin.counseling.index') }}"
                class="flex items-center gap-2.5 flex-wrap"
                x-data="{ exportOpen: false }">
                
                {{-- Filter Label --}}
                <div class="flex items-center gap-1.5 text-slate-500 text-xs font-bold uppercase tracking-wider">
                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                            clip-rule="evenodd" />
                    </svg>
                    Filter
                </div>

                {{-- Status Select --}}
                <div class="relative inline-flex items-center">
                    <select name="status" onchange="this.form.submit()" 
                        class="px-3.5 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] cursor-pointer shadow-xs transition-all appearance-none pr-8">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <svg class="w-4 h-4 text-slate-400 absolute right-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                {{-- Identity Select --}}
                <div class="relative inline-flex items-center">
                    <select name="identity" onchange="this.form.submit()" 
                        class="px-3.5 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] cursor-pointer shadow-xs transition-all appearance-none pr-8">
                        <option value="">Semua Identitas</option>
                        <option value="open" {{ request('identity') == 'open' ? 'selected' : '' }}>Terbuka</option>
                        <option value="anonymous" {{ request('identity') == 'anonymous' ? 'selected' : '' }}>Anonim</option>
                    </select>
                    <svg class="w-4 h-4 text-slate-400 absolute right-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                {{-- Reset Button --}}
                @if(request('status') || request('identity'))
                    <a href="{{ route('admin.counseling.index') }}"
                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-bold text-red-600 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-colors">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Reset
                    </a>
                @endif

                {{-- Dropdown Export Button --}}
                <div class="relative inline-block text-left" @click.outside="exportOpen = false">
                    <button type="button" @click="exportOpen = !exportOpen"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-white bg-[#064e3b] hover:bg-[#043e2f] border border-[#043e2f] rounded-xl cursor-pointer transition-colors shadow-xs">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export Data
                        <svg class="w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': exportOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="exportOpen" 
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-40 bg-white border border-slate-100 rounded-xl shadow-lg z-50 overflow-hidden py-1">
                        
                        <!-- Option Export Excel -->
                        <a href="{{ route('admin.counseling.export', request()->query()) }}"
                            class="flex items-center gap-2 px-3.5 py-2.5 text-xs font-bold text-emerald-600 hover:bg-emerald-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export Excel
                        </a>

                        <!-- Option Export PDF -->
                        <a href="{{ route('admin.counseling.exportPdf', request()->query()) }}"
                            class="flex items-center gap-2 px-3.5 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 border-t border-slate-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-4 whitespace-nowrap">Kode Tracking</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Tanggal</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Identitas</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Nama</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Rumpun</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Prodi</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Topik Masalah</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Keluhan / Konsultasi</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-4 whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-[#064e3b] bg-emerald-50 px-2 py-1 rounded-md text-xs border border-emerald-100">
                                    {{ $session->tracking_code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600">
                                <div>{{ $session->created_at->format('d M Y') }}</div>
                                <div class="text-slate-400 text-[11px]">{{ $session->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold
                                    {{ $session->identity_type == 'anonymous' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-[#064e3b]' }}">
                                    {{ ucfirst($session->identity_type) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-medium">
                                @if($session->identity_type == 'open')
                                    <span class="font-bold text-slate-900">{{ $session->name }}</span>
                                @else
                                    <span class="italic text-slate-400 text-xs">Disembunyikan</span>
                                @endif
                            </td>
                            {{-- Kolom Rumpun ($session->division) --}}
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600">
                                @if($session->identity_type == 'open')
                                    {{ $session->division }}
                                @else
                                    <span class="text-slate-300">&mdash;</span>
                                @endif
                            </td>
                            {{-- Kolom Prodi ($session->jabatan) --}}
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600">
                                @if($session->identity_type == 'open')
                                    {{ $session->jabatan }}
                                @else
                                    <span class="text-slate-300">&mdash;</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 min-w-[140px] font-medium text-slate-800">
                                {{ $topicLabels[$session->topic] ?? $session->topic ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 max-w-[240px] min-w-[180px]">
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed" title="{{ $session->issue_description }}">
                                    {{ $session->issue_description }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold
                                    @if($session->status == 'pending') bg-amber-100 text-amber-700
                                    @elseif($session->status == 'in_progress') bg-blue-100 text-blue-700
                                    @elseif($session->status == 'completed') bg-emerald-100 text-[#064e3b]
                                    @elseif($session->status == 'rejected') bg-red-100 text-red-700
                                    @else bg-amber-100 text-amber-700
                                    @endif">
                                    @if($session->status == 'pending') Pending
                                    @elseif($session->status == 'in_progress') Dalam Proses
                                    @elseif($session->status == 'completed') Selesai
                                    @elseif($session->status == 'rejected') Ditolak
                                    @else Pending
                                    @endif
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                <a href="{{ route('admin.counseling.show', $session->id) }}" 
                                    class="inline-flex items-center gap-1 bg-[#064e3b] hover:bg-[#043e2f] text-white px-3 py-1.5 rounded-lg font-bold text-xs transition-colors shadow-xs">
                                    <span>Detail / Reply</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-12 text-slate-400 text-sm">
                                Belum ada data konseling.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-5">
            {{ $sessions->links() }}
        </div>
    </div>
@endsection