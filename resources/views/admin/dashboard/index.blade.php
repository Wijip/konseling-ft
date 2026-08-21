@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <style>
        /* Recent Item - clickable row */
        .recent-item-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            border-radius: 0.625rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .recent-item-link:hover {
            background: #F9FAFB;
            border-color: #E5E7EB;
            transform: translateX(4px);
        }

        .recent-item-link+.recent-item-link {
            border-top: 1px solid #F3F4F6;
        }

        .recent-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
            color: #fff;
        }

        /* Avatar Hijau UNESA */
        .recent-avatar.chat {
            background: linear-gradient(135deg, #064e3b, #047857);
        }

        .recent-avatar.meeting {
            background: linear-gradient(135deg, #d97706, #b45309);
        }

        .recent-info {
            flex: 1;
            min-width: 0;
        }

        .recent-info .name {
            font-weight: 600;
            font-size: 0.875rem;
            color: #1F2937;
            margin: 0 0 0.125rem 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .recent-info .meta {
            font-size: 0.75rem;
            color: #9CA3AF;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .recent-info .meta .code {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: #064e3b;
        }

        .recent-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            white-space: nowrap;
            letter-spacing: 0.025em;
        }

        .recent-badge.pending {
            background: #FEF3C7;
            color: #D97706;
        }

        .recent-badge.active {
            background: #ECFDF5;
            color: #064E3B;
        }

        .recent-badge.approved {
            background: #D1FAE5;
            color: #047857;
        }

        .recent-badge.rejected {
            background: #FEE2E2;
            color: #DC2626;
        }

        .recent-badge.completed {
            background: #E0E7FF;
            color: #4F46E5;
        }

        .recent-badge.cancelled {
            background: #F3F4F6;
            color: #6B7280;
        }

        .recent-arrow {
            color: #D1D5DB;
            transition: color 0.2s, transform 0.2s;
            flex-shrink: 0;
        }

        .recent-item-link:hover .recent-arrow {
            color: #064e3b;
            transform: translateX(2px);
        }

        .recent-date {
            font-size: 0.7rem;
            color: #9CA3AF;
            text-align: right;
            white-space: nowrap;
            margin-right: 0.5rem;
        }

        .recent-link {
            color: #064e3b;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .recent-link:hover {
            color: #043e2f;
        }

        /* Stat card clickable */
        .stat-card {
            cursor: default;
        }

        .stat-card a {
            text-decoration: none;
            color: inherit;
        }

        /* Empty state */
        .recent-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            color: #9CA3AF;
            font-size: 0.875rem;
        }

        .recent-empty svg {
            width: 2.5rem;
            height: 2.5rem;
            margin-bottom: 0.75rem;
            opacity: 0.4;
        }
    </style>
@endpush

@section('content')
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.875rem; font-weight: 800; color: #064e3b; margin-bottom: 0.25rem;">Dashboard</h1>
        <p style="color: #6b7280;">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-green">
            <div class="stat-icon" style="background-color: #ecfdf5; color: #064e3b;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Konseling Chat</p>
                <p class="stat-value">{{ $totalCounseling }}</p>
            </div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-icon" style="background-color: #d1fae5; color: #047857;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Konseling Chat Aktif</p>
                <p class="stat-value">{{ $activeCounseling }}</p>
            </div>
        </div>

        <div class="stat-card stat-yellow">
            <div class="stat-icon" style="background-color: #fef3c7; color: #d97706;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Booking Pertemuan</p>
                <p class="stat-value">{{ $totalBooking }}</p>
            </div>
        </div>

        <div class="stat-card stat-blue">
            <div class="stat-icon" style="background-color: #e0f2fe; color: #0284c7;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Booking Mendatang</p>
                <p class="stat-value">{{ $upcomingBooking }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Items -->
    <div class="recent-grid">
        <!-- Recent Counseling -->
        <div class="recent-section">
            <div class="recent-header">
                <h2 class="recent-title" style="color: #0f172a; font-weight: 800;">Konseling Terbaru</h2>
                <a href="{{ route('admin.counseling.index') }}" class="recent-link">Lihat Semua →</a>
            </div>
            <div>
                @forelse($recentCounselings as $counseling)
                    <a href="{{ route('admin.counseling.show', $counseling->id) }}" class="recent-item-link">
                        <div class="recent-avatar chat">
                            {{ strtoupper(substr($counseling->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="recent-info">
                            <p class="name">
                                @if($counseling->identity_type === 'anonymous')
                                    Anonim
                                @else
                                    {{ $counseling->name }}
                                @endif
                            </p>
                            <p class="meta">
                                <span class="code">{{ $counseling->tracking_code }}</span>
                                <span>•</span>
                                <span>{{ $counseling->created_at->diffForHumans() }}</span>
                            </p>
                        </div>
                        <span class="recent-badge {{ $counseling->status }}">
                            @if($counseling->status == 'pending') Pending
                            @elseif($counseling->status == 'active') Aktif
                            @elseif($counseling->status == 'completed') Selesai
                            @else {{ ucfirst($counseling->status) }}
                            @endif
                        </span>
                        <svg class="recent-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @empty
                    <div class="recent-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Belum ada konseling terbaru
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="recent-section">
            <div class="recent-header">
                <h2 class="recent-title" style="color: #0f172a; font-weight: 800;">Booking Terbaru</h2>
                <a href="{{ route('admin.bookings.index') }}" class="recent-link">Lihat Semua →</a>
            </div>
            <div>
                @forelse($recentBookings as $booking)
                    <a href="{{ route('admin.bookings.index') }}" class="recent-item-link">
                        <div class="recent-avatar meeting">
                            {{ strtoupper(substr($booking->name, 0, 1)) }}
                        </div>
                        <div class="recent-info">
                            <p class="name">{{ $booking->name }}</p>
                            <p class="meta">
                                <span class="code">{{ $booking->tracking_code }}</span>
                                <span>•</span>
                                <span>{{ $booking->schedule->schedule_date->format('d M Y') }}</span>
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <span class="recent-badge {{ $booking->status }}">
                                @if($booking->status == 'pending') Pending
                                @elseif($booking->status == 'approved') Disetujui
                                @elseif($booking->status == 'completed') Selesai
                                @else {{ ucfirst($booking->status) }}
                                @endif
                            </span>
                            <p class="recent-date">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                        <svg class="recent-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @empty
                    <div class="recent-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Belum ada booking
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection