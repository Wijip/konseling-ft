@extends('admin.layouts.app')

@section('title', 'Daftar Booking Pertemuan')

@push('styles')
    <style>
        /* ===== Table Styles ===== */
        .booking-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .booking-table thead th {
            padding: 0.875rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #F9FAFB;
            border-bottom: 2px solid #E5E7EB;
            white-space: nowrap;
        }

        .booking-table tbody td {
            padding: 1rem;
            font-size: 0.875rem;
            color: #374151;
            vertical-align: middle;
            border-bottom: 1px solid #F3F4F6;
        }

        .booking-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .booking-table tbody tr:hover {
            background-color: #F9FAFB;
        }

        .tracking-code {
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.8rem;
            font-weight: 700;
            color: #DC2626;
            letter-spacing: 0.025em;
        }

        .schedule-cell {
            white-space: nowrap;
        }

        .schedule-cell .date {
            font-weight: 600;
            color: #111827;
            font-size: 0.8rem;
        }

        .schedule-cell .time {
            color: #9CA3AF;
            font-size: 0.75rem;
            margin-top: 0.125rem;
        }

        .konselor-cell {
            font-weight: 500;
            color: #374151;
            font-size: 0.8rem;
        }

        .name-cell {
            font-weight: 600;
            color: #111827;
        }

        .info-cell {
            color: #6B7280;
            font-size: 0.8rem;
        }

        .purpose-cell {
            min-width: 200px;
            white-space: normal;
            word-wrap: break-word;
            color: #374151;
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            background: #FEF3C7;
            color: #D97706;
        }

        .status-approved {
            background: #D1FAE5;
            color: #059669;
        }

        .status-completed {
            background: #E0E7FF;
            color: #4F46E5;
        }

        .status-rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* ===== Modal Styles ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 460px;
            overflow: hidden;
            animation: modalSlideIn 0.25s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);
            padding: 1.25rem 1.5rem;
            color: #fff;
        }

        .modal-header h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
        }

        .modal-header p {
            font-size: 0.8rem;
            opacity: 0.85;
            margin: 0;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-form-group {
            margin-bottom: 1.25rem;
        }

        .modal-form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .modal-form-group select,
        .modal-form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 0.625rem;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #1F2937;
            background: #F9FAFB;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            box-sizing: border-box;
        }

        .modal-form-group select:focus,
        .modal-form-group textarea:focus {
            border-color: #064e3b;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.15);
            background: #fff;
        }

        .modal-form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .modal-info-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: #F3F4F6;
            border-radius: 0.625rem;
            margin-bottom: 1.25rem;
        }

        .modal-info-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #064e3b, #047857);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .modal-info-text {
            flex: 1;
            min-width: 0;
        }

        .modal-info-text .name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1F2937;
        }

        .modal-info-text .detail {
            font-size: 0.75rem;
            color: #6B7280;
            margin-top: 0.125rem;
        }

        .modal-footer {
            display: flex;
            gap: 0.75rem;
            padding: 0 1.5rem 1.5rem 1.5rem;
        }

        .modal-btn {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .modal-btn-cancel {
            background: #F3F4F6;
            color: #4B5563;
        }

        .modal-btn-cancel:hover {
            background: #E5E7EB;
        }

        .modal-btn-save {
            background: linear-gradient(135deg, #064e3b 0%, #043e2f 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.3);
        }

        .modal-btn-save:hover {
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.4);
            transform: translateY(-1px);
        }

        .btn-update-status {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 0.875rem;
            background: #fff;
            color: #374151;
            border: 1.5px solid #E5E7EB;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-update-status:hover {
            border-color: #064e3b;
            color: #064e3b;
            background: #ECFDF5;
        }

        .btn-update-status svg {
            width: 0.875rem;
            height: 0.875rem;
        }

        .filter-select:hover {
            border-color: #9CA3AF;
            background-color: #F9FAFB;
        }

        .filter-select:focus {
            border-color: #064e3b;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="font-weight: 700; font-size: 1.125rem; color: #111827; margin: 0;">Semua Permintaan Booking</h3>
                <p style="color: #6B7280; font-size: 0.875rem; margin: 0.25rem 0 0 0;">Validasi permintaan pertemuan tatap
                    muka.</p>
            </div>

            <div style="display: flex; align-items: center; gap: 0.625rem; flex-wrap: wrap;">
                <form method="GET" action="{{ route('admin.bookings.index') }}" id="filterForm"
                    style="display: flex; align-items: center; gap: 0.625rem; flex-wrap: wrap;">
                    {{-- Filter Label --}}
                    <div
                        style="display: flex; align-items: center; gap: 0.375rem; color: #6B7280; font-size: 0.8rem; font-weight: 600; letter-spacing: 0.025em;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.875rem; height: 0.875rem;" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter
                    </div>

                    {{-- Konselor Select --}}
                    <div style="position: relative; display: inline-flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            style="position: absolute; left: 0.625rem; width: 0.875rem; height: 0.875rem; color: #9CA3AF; pointer-events: none;"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        <select name="konselor" onchange="this.form.submit()" class="filter-select"
                            style="padding: 0.5rem 2rem 0.5rem 2rem; border: 1px solid #D1D5DB; border-radius: 0.5rem; font-size: 0.8rem; color: #374151; background-color: #fff; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%236B7280%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s, box-shadow 0.15s; outline: none; font-family: inherit;">
                            <option value="">Semua Konselor</option>
                            @foreach($konselorList as $konselor)
                                <option value="{{ $konselor }}" {{ request('konselor') == $konselor ? 'selected' : '' }}>
                                    {{ $konselor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tipe Select --}}
                    <div style="position: relative; display: inline-flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            style="position: absolute; left: 0.625rem; width: 0.875rem; height: 0.875rem; color: #9CA3AF; pointer-events: none;"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                clip-rule="evenodd" />
                        </svg>
                        <select name="tipe" onchange="this.form.submit()" class="filter-select"
                            style="padding: 0.5rem 2rem 0.5rem 2rem; border: 1px solid #D1D5DB; border-radius: 0.5rem; font-size: 0.8rem; color: #374151; background-color: #fff; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%236B7280%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s, box-shadow 0.15s; outline: none; font-family: inherit;">
                            <option value="">Semua Tipe</option>
                            <option value="online" {{ request('tipe') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ request('tipe') == 'offline' ? 'selected' : '' }}>Langsung</option>
                        </select>
                    </div>

                    {{-- Status Select --}}
                    <div style="position: relative; display: inline-flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            style="position: absolute; left: 0.625rem; width: 0.875rem; height: 0.875rem; color: #9CA3AF; pointer-events: none;"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        <select name="status" onchange="this.form.submit()" class="filter-select"
                            style="padding: 0.5rem 2rem 0.5rem 2rem; border: 1px solid #D1D5DB; border-radius: 0.5rem; font-size: 0.8rem; color: #374151; background-color: #fff; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%236B7280%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s, box-shadow 0.15s; outline: none; font-family: inherit;">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    @if(request('konselor') || request('tipe') || request('status'))
                        <a href="{{ route('admin.bookings.index') }}"
                            style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.4rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #DC2626; background: #FEF2F2; border: 1px solid #FECACA; border-radius: 0.5rem; text-decoration: none; transition: all 0.15s; cursor: pointer;"
                            onmouseover="this.style.background='#FEE2E2'; this.style.borderColor='#FCA5A5';"
                            onmouseout="this.style.background='#FEF2F2'; this.style.borderColor='#FECACA';">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.7rem; height: 0.7rem;" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>

                {{-- Dropdown Export Button --}}
                <div x-data="{ openExport: false }" style="position: relative; display: inline-block;">
                    <button type="button" @click="openExport = !openExport" @click.outside="openExport = false"
                        style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.4rem 0.875rem; font-size: 0.75rem; font-weight: 600; color: #fff; background: #064e3b; border: 1px solid #043e2f; border-radius: 0.5rem; transition: all 0.15s; cursor: pointer;"
                        onmouseover="this.style.background='#043e2f';" onmouseout="this.style.background='#064e3b';">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.875rem; height: 0.875rem;" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.75rem; height: 0.75rem; margin-left: 0.125rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Menu Pilihan Export --}}
                    <div x-show="openExport" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        style="position: absolute; right: 0; margin-top: 0.5rem; width: 10rem; background: #ffffff; border: 1px solid #E5E7EB; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 50; overflow: hidden; display: none;"
                        :style="openExport ? 'display: block;' : 'display: none;'">
                        
                        {{-- Opsi 1: Excel --}}
                        <a href="{{ route('admin.bookings.export', array_merge(request()->query(), ['format' => 'excel'])) }}"
                            style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.8rem; font-weight: 600; color: #1F2937; text-decoration: none; transition: background 0.15s;"
                            onmouseover="this.style.background='#F3F4F6';" onmouseout="this.style.background='transparent';">
                            <svg style="width: 1rem; height: 1rem; color: #10B981;" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>
                            </svg>
                            Export Excel
                        </a>

                        {{-- Opsi 2: PDF --}}
                        <a href="{{ route('admin.bookings.export', array_merge(request()->query(), ['format' => 'pdf'])) }}"
                            style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.8rem; font-weight: 600; color: #1F2937; text-decoration: none; border-top: 1px solid #F3F4F6; transition: background 0.15s;"
                            onmouseover="this.style.background='#F3F4F6';" onmouseout="this.style.background='transparent';">
                            <svg style="width: 1rem; height: 1rem; color: #EF4444;" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2h2v2zm0-4H9V7h2v5z"/>
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Kode Tracking</th>
                        <th>Tipe</th>
                        <th>Jadwal Diminta</th>
                        <th>Konselor</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <span class="tracking-code">{{ $booking->tracking_code }}</span>
                            </td>
                            <td>
                                @if($booking->meeting_type == 'online')
                                    <span class="badge"
                                        style="background: #E0E7FF; color: #4F46E5; font-size: 0.7rem;">Online</span>
                                @else
                                    <span class="badge"
                                        style="background: #F3F4F6; color: #374151; font-size: 0.7rem;">Langsung</span>
                                @endif
                            </td>
                            <td class="schedule-cell">
                                <div class="date">{{ $booking->schedule->schedule_date->format('d M Y') }}</div>
                                <div class="time">
                                    {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                </div>
                            </td>
                            <td class="konselor-cell">
                                {{ $booking->schedule->konselor_name ?? '-' }}
                            </td>
                            <td class="name-cell">
                                {{ $booking->name }}
                            </td>
                            <td class="info-cell">
                                {{ $booking->jabatan }}
                            </td>
                            <td class="info-cell">
                                {{ $booking->division }}
                            </td>
                            <td class="purpose-cell">
                                {{ $booking->purpose }}
                            </td>
                            <td>
                                <span class="badge-status status-{{ $booking->status }}">
                                    @if($booking->status == 'pending') Pending
                                    @elseif($booking->status == 'approved') Disetujui
                                    @elseif($booking->status == 'completed') Selesai
                                    @elseif($booking->status == 'rejected') Ditolak
                                    @else {{ ucfirst($booking->status) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div x-data="{ open: false }">
                                    {{-- Trigger Button --}}
                                    <button @click="open = true" class="btn-update-status">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Update
                                    </button>

                                    {{-- Modal Overlay --}}
                                    <template x-teleport="body">
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="modal-overlay" @click.self="open = false"
                                            @keydown.escape.window="open = false" style="display: none;">

                                            {{-- Modal Card --}}
                                            <div class="modal-card" @click.stop>
                                                {{-- Header --}}
                                                <div class="modal-header">
                                                    <h4>Update Status Booking</h4>
                                                    <p>{{ $booking->tracking_code }}</p>
                                                </div>

                                                {{-- Body --}}
                                                <div class="modal-body">
                                                    {{-- User Info --}}
                                                    <div class="modal-info-row">
                                                        <div class="modal-info-avatar">
                                                            {{ strtoupper(substr($booking->name, 0, 1)) }}
                                                        </div>
                                                        <div class="modal-info-text">
                                                            <div class="name">{{ $booking->name }}</div>
                                                            <div class="detail">{{ $booking->jabatan }} &bull;
                                                                {{ $booking->division }}
                                                            </div>
                                                            <div class="detail">
                                                                {{ $booking->schedule->schedule_date->format('d M Y') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('admin.bookings.update', $booking->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        {{-- Status Select --}}
                                                        <div class="modal-form-group">
                                                            <label>Status</label>
                                                            <select name="status">
                                                                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                                                                <option value="rejected">❌ Ditolak</option>
                                                            </select>
                                                            @if($booking->status == 'completed')
                                                                <p style="font-size: 0.75rem; color: #6B7280; margin-top: 0.5rem;">
                                                                    ⚠️ Booking ini sudah berstatus <strong>Selesai</strong> dan
                                                                    tidak dapat diubah.</p>
                                                            @endif
                                                        </div>

                                                        {{-- Admin Notes --}}
                                                        <div class="modal-form-group">
                                                            <label>Balasan / Catatan</label>
                                                            <textarea name="admin_notes"
                                                                placeholder="Tulis balasan atau catatan untuk pemohon..."
                                                                rows="3">{{ $booking->admin_notes }}</textarea>
                                                        </div>

                                                        {{-- Action Buttons --}}
                                                        <div class="modal-footer" style="padding: 0;">
                                                            <button type="button" class="modal-btn modal-btn-cancel"
                                                                @click="open = false">Batal</button>
                                                            <button type="submit" class="modal-btn modal-btn-save">💾
                                                                Simpan</button>
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
                            <td colspan="10" style="text-align: center; padding: 3rem 1rem; color: #9CA3AF;">
                                Belum ada booking masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $schedules->links ?? $bookings->links() }}
        </div>
    </div>
@endsection