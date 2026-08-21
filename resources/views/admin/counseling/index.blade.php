@extends('admin.layouts.app')

@section('title', 'Daftar Konseling')

@push('styles')
    <style>
        .counseling-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .counseling-table thead th {
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

        .counseling-table tbody td {
            padding: 1rem;
            font-size: 0.875rem;
            color: #374151;
            vertical-align: middle;
            border-bottom: 1px solid #F3F4F6;
        }

        .counseling-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .counseling-table tbody tr:hover {
            background-color: #F9FAFB;
        }

        .tracking-code {
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.8rem;
            font-weight: 700;
            color: #DC2626;
            letter-spacing: 0.025em;
        }

        .date-cell {
            color: #6B7280;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .badge-identity {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        .badge-open {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-anonymous {
            background: #FEE2E2;
            color: #991B1B;
        }

        .name-cell .name {
            font-weight: 600;
            color: #111827;
        }

        .name-cell .hidden-label {
            color: #9CA3AF;
            font-style: italic;
            font-size: 0.8rem;
        }

        .info-cell {
            color: #6B7280;
            font-size: 0.8rem;
        }

        .topic-cell {
            font-weight: 500;
            color: #374151;
            min-width: 140px;
            white-space: normal;
            word-wrap: break-word;
        }

        .issue-cell {
            max-width: 260px;
            min-width: 200px;
            font-size: 0.825rem;
            color: #4B5563;
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

        .status-in_progress {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-completed {
            background: #D1FAE5;
            color: #059669;
        }

        .status-rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.4rem 0.875rem;
            background: #DC2626;
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-detail:hover {
            background: #B91C1C;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .filter-select:hover {
            border-color: #9CA3AF;
            background-color: #F9FAFB;
        }

        .filter-select:focus {
            border-color: #DC2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
    </style>
@endpush

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
    <div class="card">
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="font-weight: 700; font-size: 1.125rem; color: #111827; margin: 0;">Semua Sesi Konseling</h3>
                <p style="color: #6B7280; font-size: 0.875rem; margin: 0.25rem 0 0 0;">Kelola permintaan konseling dari
                    pegawai.</p>
            </div>

            <form method="GET" action="{{ route('admin.counseling.index') }}"
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
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Identity Select --}}
                <div style="position: relative; display: inline-flex; align-items: center;">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        style="position: absolute; left: 0.625rem; width: 0.875rem; height: 0.875rem; color: #9CA3AF; pointer-events: none;"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    <select name="identity" onchange="this.form.submit()" class="filter-select"
                        style="padding: 0.5rem 2rem 0.5rem 2rem; border: 1px solid #D1D5DB; border-radius: 0.5rem; font-size: 0.8rem; color: #374151; background-color: #fff; cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%236B7280%22%3E%3Cpath fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: border-color 0.15s, box-shadow 0.15s; outline: none; font-family: inherit;">
                        <option value="">Semua Identitas</option>
                        <option value="open" {{ request('identity') == 'open' ? 'selected' : '' }}>Terbuka</option>
                        <option value="anonymous" {{ request('identity') == 'anonymous' ? 'selected' : '' }}>Anonim</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                @if(request('status') || request('identity'))
                    <a href="{{ route('admin.counseling.index') }}"
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

                {{-- Dropdown Export Button --}}
                <div style="position: relative; display: inline-block;">
                    <button type="button" id="exportDropdownBtn"
                        style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.4rem 0.875rem; font-size: 0.75rem; font-weight: 600; color: #fff; background: #064E3B; border: 1px solid #043E2F; border-radius: 0.5rem; cursor: pointer; transition: all 0.15s;"
                        onmouseover="this.style.background='#043E2F';" onmouseout="this.style.background='#064E3B';">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.875rem; height: 0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export Data
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.75rem; height: 0.75rem; margin-left: 0.125rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="exportDropdownMenu"
                        style="display: none; position: absolute; right: 0; top: calc(100% + 0.25rem); background: #ffffff; border: 1px solid #E5E7EB; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); min-width: 140px; z-index: 50; overflow: hidden;">
                        
                        <!-- Option Export Excel -->
                        <a href="{{ route('admin.counseling.export', request()->query()) }}"
                            style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.75rem; font-weight: 600; color: #10B981; text-decoration: none; transition: background 0.15s;"
                            onmouseover="this.style.background='#F0FDF4';" onmouseout="this.style.background='transparent';">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.875rem; height: 0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export Excel
                        </a>

                        <!-- Option Export PDF -->
                        <a href="{{ route('admin.counseling.exportPdf', request()->query()) }}"
                            style="display: flex; align-items: center; gap: 0.5rem; padding: 0.625rem 0.875rem; font-size: 0.75rem; font-weight: 600; color: #EF4444; border-top: 1px solid #F3F4F6; text-decoration: none; transition: background 0.15s;"
                            onmouseover="this.style.background='#FEF2F2';" onmouseout="this.style.background='transparent';">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.875rem; height: 0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="counseling-table">
                <thead>
                    <tr>
                        <th>Kode Tracking</th>
                        <th>Tanggal</th>
                        <th>Identitas</th>
                        <th>Nama</th>
                        <th>Rumpun</th>
                        <th>Prodi</th>
                        <th>Topik Masalah</th>
                        <th>Keluhan / Konsultasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                        <tr>
                            <td>
                                <span class="tracking-code">{{ $session->tracking_code }}</span>
                            </td>
                            <td class="date-cell">
                                {{ $session->created_at->format('d M Y') }}<br>
                                <span style="color: #9CA3AF;">{{ $session->created_at->format('H:i') }}</span>
                            </td>
                            <td>
                                <span
                                    class="badge-identity {{ $session->identity_type == 'anonymous' ? 'badge-anonymous' : 'badge-open' }}">
                                    {{ ucfirst($session->identity_type) }}
                                </span>
                            </td>
                            <td class="name-cell">
                                @if($session->identity_type == 'open')
                                    <span class="name">{{ $session->name }}</span>
                                @else
                                    <span class="hidden-label">Disembunyikan</span>
                                @endif
                            </td>
                            {{-- Kolom Rumpun ($session->division) --}}
                            <td class="info-cell">
                                @if($session->identity_type == 'open')
                                    {{ $session->division }}
                                @else
                                    <span style="color: #D1D5DB;">—</span>
                                @endif
                            </td>
                            {{-- Kolom Prodi ($session->jabatan) --}}
                            <td class="info-cell">
                                @if($session->identity_type == 'open')
                                    {{ $session->jabatan }}
                                @else
                                    <span style="color: #D1D5DB;">—</span>
                                @endif
                            </td>
                            <td class="topic-cell">
                                {{ $topicLabels[$session->topic] ?? $session->topic ?? '-' }}
                            </td>
                            <td class="issue-cell">
                                <p style="margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;" title="{{ $session->issue_description }}">
                                    {{ $session->issue_description }}
                                </p>
                            </td>
                            <td>
                                <span class="badge-status status-{{ $session->status ? $session->status : 'pending' }}">
                                    @if($session->status == 'pending') Pending
                                    @elseif($session->status == 'in_progress') Dalam Proses
                                    @elseif($session->status == 'completed') Selesai
                                    @elseif($session->status == 'rejected') Ditolak
                                    @else Pending
                                    @endif
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.counseling.show', $session->id) }}" class="btn-detail">
                                    Detail / Reply
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 3rem 1rem; color: #9CA3AF;">
                                Belum ada data konseling.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sessions->links() }}
        </div>
    </div>

    {{-- Script Toggle Dropdown Export --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('exportDropdownBtn');
            const menu = document.getElementById('exportDropdownMenu');

            if (btn && menu) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
                });

                document.addEventListener('click', function (e) {
                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                        menu.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection