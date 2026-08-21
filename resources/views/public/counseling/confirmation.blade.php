@extends('layouts.app')

@section('title', 'Konfirmasi Konseling - Konseling FT UNESA')

@section('content')
    <style>
        .btn-green-action {
            background-color: #064e3b;
            color: #ffffff;
            display: inline-block;
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
        }
        .btn-green-action:hover {
            background-color: #043e2f;
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.3);
        }
    </style>

    <div style="padding: 3rem 1rem 5rem 1rem; background-color: #f9fafb; min-height: calc(100vh - 160px);">
        <div style="max-width: 32rem; margin: 0 auto; padding: 0 1rem;">
            
            {{-- Card Utama --}}
            <div style="background: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 2.5rem 2rem; text-align: center;">
                
                {{-- Success Icon --}}
                <div style="width: 5rem; height: 5rem; background-color: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <svg style="width: 2.5rem; height: 2.5rem; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                {{-- Title & Subtitle --}}
                <h1 style="font-size: 1.75rem; font-weight: 800; color: #111827; margin: 0 0 0.5rem 0;">
                    Konseling Berhasil Dibuat
                </h1>
                <p style="color: #6b7280; font-size: 0.95rem; margin: 0 0 2rem 0; line-height: 1.5;">
                    Simpan kode tracking berikut untuk melanjutkan chat konseling Anda.
                </p>

                {{-- Kode Tracking Box (Hijau UNESA) --}}
                <div style="background-color: #f0fdf4; border: 2px dashed #064e3b; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem;">
                    <p style="font-size: 0.75rem; color: #064e3b; margin: 0 0 0.5rem 0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                        Kode Tracking
                    </p>
                    <p style="font-size: 2rem; font-weight: 900; color: #064e3b; font-family: 'Courier New', monospace; letter-spacing: 0.15em; margin: 0;">
                        {{ $session->tracking_code }}
                    </p>
                </div>

                {{-- Alert Warning --}}
                <div style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 0.75rem; padding: 1rem 1.25rem; color: #b45309; text-align: left; display: flex; gap: 0.75rem; align-items: flex-start; margin-bottom: 2rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; flex-shrink: 0; margin-top: 0.125rem; color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p style="font-size: 0.875rem; margin: 0; line-height: 1.5;">
                        <strong style="color: #92400e;">Penting:</strong> Simpan kode ini dengan baik. Anda memerlukan kode ini untuk mengakses chat konseling Anda di masa mendatang.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div style="display: flex; flex-direction: column; gap: 0.875rem; align-items: center;">
                    <a href="{{ route('counseling.chat', ['code' => $session->tracking_code]) }}" class="btn-green-action">
                        Lanjutkan ke Chat
                    </a>
                    <a href="{{ route('home') }}"
                        style="color: #6b7280; text-decoration: none; font-weight: 600; font-size: 0.875rem; padding: 0.5rem; transition: color 0.2s;"
                        onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                        Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection