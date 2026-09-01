@extends('layouts.app')

@section('title', 'Jadwal Pertemuan')

@section('content')
    <div class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50 min-h-[calc(100vh-160px)] flex flex-col justify-center">
        <div class="w-full max-w-5xl mx-auto">
            
            <!-- Back Link -->
            <div class="mb-6">
                <a href="{{ route('counseling.mode') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#064e3b] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Pilih Mode
                </a>
            </div>

            <!-- Main Calendar Card Container -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[580px]">
                    
                    <!-- Left Column: Calendar Grid -->
                    <div class="lg:col-span-7 p-5 sm:p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-gray-100 flex flex-col justify-between">
                        <div>
                            <!-- Header Nav Month -->
                            <div class="flex items-center justify-between mb-6 sm:mb-8">
                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900">
                                    {{ $startDate->translatedFormat('F Y') }}
                                </h2>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <a href="{{ route('meeting.calendar', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}"
                                        class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors"
                                        aria-label="Bulan Sebelumnya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('meeting.calendar', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}"
                                        class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors"
                                        aria-label="Bulan Selanjutnya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Calendar Grid -->
                            <div class="grid grid-cols-7 gap-1 text-center mb-4">
                                <!-- Day Headers -->
                                @foreach(['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'] as $day)
                                    <div class="text-[11px] sm:text-xs font-bold text-gray-400 py-2">
                                        {{ $day }}
                                    </div>
                                @endforeach

                                <!-- Empty Cells Previous Month -->
                                @for($i = 1; $i < $startDate->dayOfWeekIso; $i++)
                                    <div class="aspect-square flex items-center justify-center text-gray-300 text-xs sm:text-sm font-medium">
                                        {{ $startDate->copy()->subDays($startDate->dayOfWeekIso - $i)->day }}
                                    </div>
                                @endfor

                                <!-- Days -->
                                @for($day = 1; $day <= $startDate->daysInMonth; $day++)
                                    @php
                                        $date = $startDate->copy()->day($day);
                                        $dateStr = $date->format('Y-m-d');
                                        $isToday = $date->isToday();
                                        $isSelected = $selectedDate->format('Y-m-d') === $dateStr;
                                        $hasSlots = $slots->has($dateStr);
                                        $isPast = $date->isPast() && !$isToday;
                                    @endphp

                                    <div class="aspect-square flex items-center justify-center p-0.5 relative">
                                        <a href="{{ !$isPast ? route('meeting.calendar', ['month' => $month, 'year' => $year, 'date' => $dateStr]) : '#' }}"
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-medium transition-all relative z-10
                                            {{ $isSelected ? 'bg-[#064e3b] text-white font-bold shadow-md shadow-[#064e3b]/30' : ($isToday ? 'border-2 border-[#064e3b] text-[#064e3b] font-bold' : ($isPast ? 'text-gray-300 cursor-default' : 'text-gray-700 hover:bg-gray-100')) }}">
                                            <span>{{ $day }}</span>

                                            @if($hasSlots && !$isSelected)
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full absolute bottom-1"></span>
                                            @endif
                                        </a>
                                    </div>
                                @endfor

                                <!-- Empty Cells Next Month -->
                                @php $remaining = 7 - (($startDate->dayOfWeekIso - 1 + $startDate->daysInMonth) % 7); @endphp
                                @if($remaining < 7)
                                    @for($i = 1; $i <= $remaining; $i++)
                                        <div class="aspect-square flex items-center justify-center text-gray-300 text-xs sm:text-sm font-medium">
                                            {{ $i }}
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-4 sm:gap-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-[#064e3b] text-white flex items-center justify-center text-[10px] font-bold">30</span>
                                Dipilih
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-white border-2 border-[#064e3b] text-[#064e3b] flex items-center justify-center text-[10px] font-bold">30</span>
                                Hari Ini
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center text-[10px] font-bold relative">
                                    30
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full absolute bottom-0.5"></span>
                                </span>
                                Tersedia
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Slots -->
                    <div class="lg:col-span-5 p-5 sm:p-8 lg:p-10 flex flex-col justify-between bg-white" x-data="{ selectedSlot: null }">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-1">Pilih Jam & Konselor</h2>
                            <p class="text-gray-500 text-sm sm:text-base mb-6">
                                {{ $selectedDate->translatedFormat('l, d F Y') }}
                            </p>

                            <div class="max-h-[360px] overflow-y-auto pr-1 space-y-3">
                                @forelse($selectedDateSlots as $slot)
                                    <div @click="selectedSlot = {{ $slot->id }}"
                                        class="cursor-pointer border-2 rounded-2xl p-4 transition-all flex items-center justify-between gap-3 bg-white hover:border-[#064e3b]"
                                        :class="selectedSlot === {{ $slot->id }} ? 'bg-[#064e3b] border-[#064e3b] text-white shadow-lg shadow-[#064e3b]/20' : 'border-gray-100 text-gray-800'">

                                        {{-- Jam dan Status --}}
                                        <div class="flex flex-col shrink-0">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 shrink-0" :class="selectedSlot === {{ $slot->id }} ? 'text-white' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-sm sm:text-base font-extrabold whitespace-nowrap">
                                                    {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                                                </span>
                                            </div>
                                            <span class="text-[11px] font-semibold pl-5 opacity-80">
                                                Tersedia
                                            </span>
                                        </div>

                                        {{-- Pembatas / Divider --}}
                                        <div class="h-8 w-[1px] shrink-0" :class="selectedSlot === {{ $slot->id }} ? 'bg-white/20' : 'bg-gray-200'"></div>

                                        {{-- Nama Konselor & Rumpun --}}
                                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                                                :class="selectedSlot === {{ $slot->id }} ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            
                                            <div class="flex flex-col min-w-0">
                                                <div class="font-extrabold text-xs sm:text-sm uppercase leading-tight truncate">
                                                    {{ $slot->konselor_name ?? ($slot->konselor->name ?? 'Tim HC') }}
                                                </div>
                                                
                                                @php
                                                    $rumpun = $slot->rumpun ?? ($slot->konselor->rumpun ?? null);
                                                @endphp

                                                @if($rumpun)
                                                    <div class="text-[11px] font-medium opacity-80 truncate">
                                                        {{ $rumpun }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-gray-700">Tidak ada slot</h3>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Pilih tanggal lain yang tersedia.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <a x-show="selectedSlot" :href="`/meeting/book/${selectedSlot}`"
                                class="w-full inline-block bg-[#064e3b] hover:bg-[#04382a] text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-center text-sm sm:text-base">
                                Lanjutkan
                            </a>

                            <div x-show="!selectedSlot"
                                class="w-full bg-gray-200 text-gray-400 font-bold py-3.5 px-6 rounded-xl text-center text-sm sm:text-base cursor-not-allowed">
                                Lanjutkan
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection