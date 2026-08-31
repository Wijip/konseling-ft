@extends('layouts.app')

@section('title', 'Riwayat Konseling Saya')

@section('content')
<div style="max-width: 1280px; margin: 2rem auto; padding: 0 1rem;">
    <!-- Header Section -->
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem;">Riwayat Konseling</h1>
        <p style="color: #64748b; font-size: 0.95rem;">Daftar dan statistik sesi konseling online serta pertemuan yang pernah Anda ajukan.</p>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Total Konseling</div>
            <div style="font-size: 2.25rem; font-weight: 800; color: #2563eb;">{{ $totalCounseling }}</div>
            <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Kali Konsultasi</div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Chat Online</div>
            <div style="font-size: 2.25rem; font-weight: 800; color: #059669;">{{ $totalChat }}</div>
            <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Sesi Terdaftar</div>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">Pertemuan (Tatap Muka/Zoom)</div>
            <div style="font-size: 2.25rem; font-weight: 800; color: #d97706;">{{ $totalMeetings }}</div>
            <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Jadwal Pertemuan</div>
        </div>
    </div>

    <!-- Section Chat Online -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; margin-bottom: 2.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.75rem;">
            💬 Riwayat Konseling Chat Online
        </h2>

        @if($counselingSessions->isEmpty())
            <p style="color: #94a3b8; font-size: 0.9rem; text-align: center; padding: 2rem 0;">Belum ada riwayat sesi konseling chat online.</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                    <thead>
                        <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;">
                            <th style="padding: 0.75rem 1rem;">Kode Tracking</th>
                            <th style="padding: 0.75rem 1rem;">Topik Masalah</th>
                            <th style="padding: 0.75rem 1rem;">Tanggal Pengajuan</th>
                            <th style="padding: 0.75rem 1rem;">Status</th>
                            <th style="padding: 0.75rem 1rem; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($counselingSessions as $session)
                            <tr style="border-bottom: 1px solid #f1f5f9; color: #334155;">
                                <td style="padding: 0.875rem 1rem; font-weight: 600; color: #2563eb;">{{ $session->tracking_code }}</td>
                                <td style="padding: 0.875rem 1rem;">{{ $session->issue_topic ?? 'Umum' }}</td>
                                <td style="padding: 0.875rem 1rem;">{{ $session->created_at->format('d M Y, H:i') }} WIB</td>
                                <td style="padding: 0.875rem 1rem;">
                                    @if($session->status === 'pending')
                                        <span style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">Pending</span>
                                    @elseif($session->status === 'in_progress')
                                        <span style="background: #dbeafe; color: #1d4ed8; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">In Progress</span>
                                    @elseif($session->status === 'completed')
                                        <span style="background: #d1fae5; color: #047857; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">Selesai</span>
                                    @else
                                        <span style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">Ditolak</span>
                                    @endif
                                </td>
                                <td style="padding: 0.875rem 1rem; text-align: center;">
                                    <a href="{{ route('counseling.chat', $session->tracking_code) }}" style="display: inline-block; padding: 0.35rem 0.85rem; background-color: #2563eb; color: #ffffff; border-radius: 0.375rem; text-decoration: none; font-weight: 600; font-size: 0.8rem;">
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
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.75rem;">
            📅 Riwayat Booking Pertemuan
        </h2>

        @if($meetingBookings->isEmpty())
            <p style="color: #94a3b8; font-size: 0.9rem; text-align: center; padding: 2rem 0;">Belum ada riwayat booking pertemuan.</p>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                    <thead>
                        <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;">
                            <th style="padding: 0.75rem 1rem;">Kode Tracking</th>
                            <th style="padding: 0.75rem 1rem;">Konselor</th>
                            <th style="padding: 0.75rem 1rem;">Tipe</th>
                            <th style="padding: 0.75rem 1rem;">Jadwal Pertemuan</th>
                            <th style="padding: 0.75rem 1rem;">Status</th>
                            <th style="padding: 0.75rem 1rem; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meetingBookings as $booking)
                            <tr style="border-bottom: 1px solid #f1f5f9; color: #334155;">
                                <td style="padding: 0.875rem 1rem; font-weight: 600; color: #2563eb;">{{ $booking->tracking_code }}</td>
                                <td style="padding: 0.875rem 1rem;">{{ $booking->schedule->konselor_name ?? '-' }}</td>
                                <td style="padding: 0.875rem 1rem;">
                                    @if($booking->meeting_type === 'online')
                                        <span style="color: #2563eb; font-weight: 600;">Online (Zoom)</span>
                                    @else
                                        <span style="color: #475569; font-weight: 600;">Langsung</span>
                                    @endif
                                </td>
                                <td style="padding: 0.875rem 1rem;">
                                    @if($booking->schedule)
                                        {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }} ({{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }})
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="padding: 0.875rem 1rem;">
                                    @if($booking->status === 'pending')
                                        <span style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">Pending</span>
                                    @elseif($booking->status === 'approved')
                                        <span style="background: #d1fae5; color: #047857; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">Disetujui</span>
                                    @elseif($booking->status === 'completed')
                                        <span style="background: #e0e7ff; color: #3730a3; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">Selesai</span>
                                    @else
                                        <span style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">Ditolak</span>
                                    @endif
                                </td>
                                <td style="padding: 0.875rem 1rem; text-align: center;">
                                    <a href="{{ route('tracking.show', $booking->tracking_code) }}" style="display: inline-block; padding: 0.35rem 0.85rem; background-color: #0f172a; color: #ffffff; border-radius: 0.375rem; text-decoration: none; font-weight: 600; font-size: 0.8rem;">
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
@endsection