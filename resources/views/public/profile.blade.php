@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div style="max-width: 800px; margin: 2.5rem auto; padding: 0 1rem;">
    <!-- Profile Card Header -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
            <div style="width: 70px; height: 70px; border-radius: 50%; background-color: #2563eb; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 700;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0 0 0.25rem 0;">{{ $user->name }}</h1>
                <p style="color: #64748b; margin: 0; font-size: 0.95rem;">{{ $user->email }}</p>
                <span style="display: inline-block; margin-top: 0.5rem; background: #e0e7ff; color: #3730a3; padding: 0.2rem 0.65rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem;">
                    {{ ucfirst($user->role ?? 'Pengguna') }}
                </span>
            </div>
        </div>

        <!-- Account Detail Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid #f1f5f9;">
                <span style="font-size: 0.8rem; color: #64748b; display: block; margin-bottom: 0.25rem;">Terdaftar Sejak</span>
                <strong style="color: #1e293b; font-size: 0.95rem;">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</strong>
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid #f1f5f9;">
                <span style="font-size: 0.8rem; color: #64748b; display: block; margin-bottom: 0.25rem;">Total Aktivitas Konseling</span>
                <strong style="color: #2563eb; font-size: 0.95rem;">{{ $totalCounseling }} Kali Konsultasi</strong>
            </div>
        </div>
    </div>

    <!-- Activity Summary Section -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <h2 style="font-size: 1.125rem; font-weight: 700; color: #1e293b; margin: 0 0 1rem 0;">Ringkasan Konseling</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            <div style="border: 1px solid #e2e8f0; padding: 1rem; border-radius: 0.5rem;">
                <div style="font-size: 0.85rem; color: #64748b;">Konseling Chat Online</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #059669; margin-top: 0.25rem;">{{ $totalChat }}</div>
            </div>
            <div style="border: 1px solid #e2e8f0; padding: 1rem; border-radius: 0.5rem;">
                <div style="font-size: 0.85rem; color: #64748b;">Booking Pertemuan</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #d97706; margin-top: 0.25rem;">{{ $totalMeetings }}</div>
            </div>
        </div>

        <div style="text-align: right;">
            <a href="{{ route('history') }}" style="display: inline-block; padding: 0.6rem 1.25rem; background-color: #2563eb; color: #ffffff; border-radius: 0.375rem; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                Lihat Seluruh Riwayat Konseling &rarr;
            </a>
        </div>
    </div>
</div>
@endsection