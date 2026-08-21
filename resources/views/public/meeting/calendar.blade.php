@extends('layouts.app')

@section('title', 'Jadwal Pertemuan')

@section('content')
    <style>
        /* Calendar-specific styles */
        .calendar-container {
            background: #fff;
            border-radius: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 650px;
        }

        @media (max-width: 1024px) {
            .calendar-grid {
                grid-template-columns: 1fr;
                min-height: 500px;
            }
        }

        .calendar-left {
            padding: 2.5rem;
            border-right: 1px solid #f3f4f6;
        }

        @media (max-width: 1024px) {
            .calendar-left {
                border-right: none;
                border-bottom: 1px solid #f3f4f6;
            }
        }

        .calendar-right {
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
        }

        .calendar-days-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            margin-bottom: 1.5rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 0.25rem;
        }

        .calendar-day-btn {
            width: 2.75rem;
            height: 2.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
            text-decoration: none;
            position: relative;
            z-index: 10;
        }

        /* Tanggal Dipilih -> Hijau */
        .calendar-day-selected {
            background-color: #064e3b !important;
            color: white !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.3) !important;
        }

        /* Hari Ini -> Border Hijau */
        .calendar-day-today {
            border: 1px solid #064e3b !important;
            color: #064e3b !important;
            font-weight: 700;
        }

        .calendar-day-normal {
            color: #4b5563;
            font-weight: 500;
        }

        .calendar-day-normal:hover {
            background-color: #f9fafb;
        }

        .calendar-day-past {
            color: #d1d5db;
            cursor: default;
        }

        .calendar-day-indicator {
            position: absolute;
            bottom: 0.25rem;
            width: 0.25rem;
            height: 0.25rem;
            border-radius: 50%;
            background-color: #10b981;
        }

        .slot-card {
            cursor: pointer;
            border: 2px solid #f3f4f6;
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            background: white;
            margin-bottom: 1.5rem;
        }

        /* Hover Card -> Border Hijau */
        .slot-card:hover {
            border-color: #064e3b !important;
        }

        /* Card Dipilih -> Background Hijau */
        .slot-card-selected {
            background-color: #064e3b !important;
            border-color: #064e3b !important;
            color: white !important;
            box-shadow: 0 8px 20px rgba(6, 78, 59, 0.2) !important;
        }

        .slot-time-icon {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
        }

        .slot-divider {
            border-left: 2px solid rgba(0, 0, 0, 0.05);
            padding-left: 1.5rem;
            margin-left: 1.5rem;
        }

        .slot-card-selected .slot-divider {
            border-left-color: rgba(255, 255, 255, 0.2);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            margin-bottom: 0.75rem;
        }

        .legend-dot {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
        }

        .calendar-action-btn {
            display: inline-block;
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        /* Tombol Lanjutkan -> Hijau */
        .calendar-action-btn-active {
            background-color: #064e3b !important;
            background: #064e3b !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2) !important;
        }

        .calendar-action-btn-active:hover {
            background-color: #043e2f !important;
            background: #043e2f !important;
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.3) !important;
        }

        .calendar-action-btn-disabled {
            background-color: #e5e7eb !important;
            color: #9ca3af !important;
            cursor: not-allowed;
        }
    </style>

    <div style="padding: 2rem 0; background-color: rgba(249, 250, 251, 0.3); min-height: 100vh;">
        <div class="container" style="max-width: 72rem; padding: 0 1rem;">
            <!-- Back Link -->
            <div style="margin-bottom: 1.5rem;">
                <a href="{{ route('counseling.mode') }}"
                    style="color: #6b7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 500;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Pilih Mode
                </a>
            </div>

            <div class="calendar-container">
                <div class="calendar-grid">
                    <!-- Left Column: Calendar -->
                    <div class="calendar-left">
                        <!-- Header -->
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem;">
                            <h2 style="font-size: 1.875rem; font-weight: 700; color: #111827;">
                                {{ $startDate->translatedFormat('F Y') }}
                            </h2>
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <a href="{{ route('meeting.calendar', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}"
                                    style="width: 2.5rem; height: 2.5rem; border-radius: 50%; border: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s; color: #6b7280; text-decoration: none;">
                                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </a>
                                <a href="{{ route('meeting.calendar', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}"
                                    style="width: 2.5rem; height: 2.5rem; border-radius: 50%; border: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s; color: #6b7280; text-decoration: none;">
                                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="calendar-days-grid">
                            <!-- Day Headers -->
                            @foreach(['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'] as $day)
                                <div style="text-align: center; font-size: 0.75rem; font-weight: 700; color: #9ca3af; padding: 1rem 0;">
                                    {{ $day }}
                                </div>
                            @endforeach

                            <!-- Empty Cells -->
                            @for($i = 1; $i < $startDate->dayOfWeekIso; $i++)
                                <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; color: #e5e7eb; font-size: 0.875rem; font-weight: 500;">
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

                                <div class="calendar-day">
                                    <a href="{{ !$isPast ? route('meeting.calendar', ['month' => $month, 'year' => $year, 'date' => $dateStr]) : '#' }}"
                                        class="calendar-day-btn {{ $isSelected ? 'calendar-day-selected' : ($isToday ? 'calendar-day-today' : ($isPast ? 'calendar-day-past' : 'calendar-day-normal')) }}">
                                        <span style="font-size: 1rem;">{{ $day }}</span>

                                        @if($hasSlots && !$isSelected)
                                            <div class="calendar-day-indicator"></div>
                                        @endif
                                    </a>
                                </div>
                            @endfor

                            <!-- Empty Cells (Next Month) -->
                            @php $remaining = 7 - (($startDate->dayOfWeekIso - 1 + $startDate->daysInMonth) % 7); @endphp
                            @if($remaining < 7)
                                @for($i = 1; $i <= $remaining; $i++)
                                    <div style="aspect-ratio: 1; display: flex; align-items: center; justify-content: center; color: #e5e7eb; font-size: 0.875rem; font-weight: 500;">
                                        {{ $i }}
                                    </div>
                                @endfor
                            @endif
                        </div>

                        <!-- Legend -->
                        <div style="margin-top: 3rem; padding-left: 0.5rem;">
                            <div class="legend-item">
                                <span class="legend-dot" style="background: #064e3b; color: #ffffff;">30</span>
                                Dipilih
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot" style="background: #fff; border: 2px solid #064e3b; color: #064e3b;">30</span>
                                Hari Ini
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot" style="background: #fff; position: relative;">
                                    <span style="font-size: 10px; font-weight: 700; color: #9ca3af;">30</span>
                                    <span style="position: absolute; bottom: 0; width: 0.25rem; height: 0.25rem; border-radius: 50%; background: #10b981;"></span>
                                </span>
                                Tersedia
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Slots -->
                    <div class="calendar-right" x-data="{ selectedSlot: null }">
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 0.25rem;">Pilih Jam & Konselor</h2>
                        <p style="color: #6b7280; margin-bottom: 2.5rem; font-size: 1.125rem;">
                            {{ $selectedDate->translatedFormat('l, d F Y') }}
                        </p>

                        <div style="flex: 1; overflow-y: auto; padding-right: 0.25rem;" class="no-scrollbar">
                            @forelse($selectedDateSlots as $slot)
                                <div @click="selectedSlot = {{ $slot->id }}" class="slot-card"
                                    :class="selectedSlot === {{ $slot->id }} ? 'slot-card-selected' : ''">

                                    {{-- Kolom Kiri: Jam dan Status --}}
                                    <div style="flex: 1;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                            <svg class="slot-time-icon"
                                                :style="selectedSlot === {{ $slot->id }} ? 'color: white' : 'color: #9ca3af'"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span style="font-size: 1.125rem; font-weight: 800;">
                                                {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}
                                            </span>
                                        </div>
                                        <div style="font-size: 0.875rem; font-weight: 500; opacity: 0.8; padding-left: 1.75rem;">
                                            Tersedia
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan: Nama Konselor & Rumpun --}}
                                    <div class="slot-divider" style="display: flex; align-items: center; gap: 0.75rem;">
                                        {{-- Ikon User --}}
                                        <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"
                                            :style="selectedSlot === {{ $slot->id }} ? 'background: rgba(255,255,255,0.2)' : 'background: #f9fafb'">
                                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        
                                        {{-- Teks Nama dan Rumpun --}}
                                        <div style="display: flex; flex-direction: column; justify-content: center;">
                                            {{-- Nama Konselor --}}
                                            <div style="font-weight: 800; font-size: 1rem; line-height: 1.2; text-transform: uppercase;">
                                                {{ $slot->konselor_name ?? ($slot->konselor->name ?? 'Tim HC') }}
                                            </div>
                                            
                                            {{-- Rumpun (Muncul di bawah nama) --}}
                                            @php
                                                $rumpun = $slot->rumpun ?? ($slot->konselor->rumpun ?? null);
                                            @endphp

                                            @if($rumpun)
                                                <div style="font-size: 0.85rem; font-weight: 600; opacity: 0.9; margin-top: 0.25rem; letter-spacing: 0.025em;">
                                                    {{ $rumpun }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                            @empty
                                <div style="text-align: center; padding: 5rem 0; background: #f9fafb; border-radius: 1.5rem;">
                                    <div style="width: 4rem; height: 4rem; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                        <svg style="width: 2rem; height: 2rem; color: #9ca3af;" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 style="font-size: 1.125rem; font-weight: 700; color: #6b7280;">Tidak ada slot</h3>
                                    <p style="font-size: 0.875rem; color: #9ca3af; margin-top: 0.25rem;">
                                        Pilih tanggal lain yang tersedia.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <div style="margin-top: 2rem; padding-top: 1.5rem; text-align: center;">
                            <a x-show="selectedSlot" :href="`/meeting/book/${selectedSlot}`"
                                class="calendar-action-btn calendar-action-btn-active"
                                style="background-color: #064e3b !important; background: #064e3b !important; color: #ffffff !important;">
                                Lanjutkan
                            </a>

                            <div x-show="!selectedSlot" class="calendar-action-btn calendar-action-btn-disabled">
                                Lanjutkan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection