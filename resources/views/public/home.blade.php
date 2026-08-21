@extends('layouts.app')

@section('title', 'Beranda - Layanan Konseling Fakultas Teknik')

@section('content')
    <div>
        {{-- Hero Section dengan Gambar Geser Kanan Presisi --}}
        <div style="position: relative; width: 100%; min-height: 560px; background-color: #ffffff; overflow: hidden; display: flex; align-items: center; padding: 3.5rem 0;">
            
            {{-- Background Image (Diposisikan khusus di sisi kanan) --}}
            <div style="position: absolute; top: 0; right: -40px; width: 68%; height: 100%; z-index: 1;">
                <img src="{{ asset('images/landing-hero.png') }}" alt="Gedung FT UNESA" style="width: 100%; height: 100%; object-fit: cover; object-position: center right;">
                
                {{-- Fade Gradient Mask (Membuat transisi putih di sisi kiri gambar) --}}
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, #ffffff 0%, rgba(255, 255, 255, 0.85) 25%, rgba(255, 255, 255, 0) 55%);"></div>
            </div>

            {{-- Content Area --}}
            <div style="position: relative; z-index: 2; max-width: 1280px; margin: 0 auto; padding: 0 2rem; width: 100%;">
                <div style="max-width: 500px;">
                    
                    {{-- Badge --}}
                    <div style="display: inline-block; padding: 0.4rem 1.25rem; background-color: #e5e7eb; color: #4b5563; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 1.5rem; text-transform: uppercase;">
                        Layanan Konseling Fakultas Teknik
                    </div>

                    {{-- Main Title --}}
                    <h1 style="font-size: 3.5rem; font-weight: 900; color: #064e3b; line-height: 1.05; margin: 0 0 1rem 0; letter-spacing: -0.02em;">
                        COUNSELING<br>CORNER
                    </h1>

                    {{-- Yellow Accent Line --}}
                    <div style="width: 48px; height: 4px; background-color: #f59e0b; margin-bottom: 1.5rem; border-radius: 2px;"></div>

                    {{-- Description --}}
                    <p style="color: #374151; font-size: 0.975rem; line-height: 1.6; font-weight: 500; margin-bottom: 2rem;">
                        Karena Kesehatan Mental Anda Penting. Di sini, Anda bisa berbicara dengan aman, didengar, dan didampingi secara profesional untuk menghadapi setiap tantangan.
                    </p>

                    {{-- CTA Buttons --}}
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <a href="{{ route('counseling.mode') }}" style="display: inline-flex; align-items: center; gap: 0.6rem; background-color: #064e3b; color: white; padding: 0.85rem 1.75rem; border-radius: 9999px; font-weight: 700; text-decoration: none; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Mulai Konseling
                        </a>

                        <a href="{{ route('tracking.index') }}" style="display: inline-flex; align-items: center; gap: 0.6rem; background-color: white; color: #064e3b; border: 1.5px solid #d1d5db; padding: 0.85rem 1.75rem; border-radius: 9999px; font-weight: 700; text-decoration: none; font-size: 0.95rem;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Cek Status
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features Section --}}
        <div style="background-color: #f9fafb; padding: 4rem 0;">
            <div style="max-width: 1280px; margin: 0 auto; padding: 0 2rem;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                    
                    {{-- Chat Online --}}
                    <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="width: 3.5rem; height: 3.5rem; background-color: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                                <svg style="width: 1.75rem; height: 1.75rem; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem 0;">Chat Online</h3>
                            <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.5; margin-bottom: 1.5rem;">
                                Konseling tertulis yang fleksibel. Tersedia opsi anonim untuk privasi maksimal.
                            </p>
                        </div>
                        <a href="{{ route('counseling.mode') }}" style="color: #064e3b; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                            PILIH LAYANAN &rarr;
                        </a>
                    </div>

                    {{-- Pertemuan Langsung --}}
                    <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="width: 3.5rem; height: 3.5rem; background-color: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                                <svg style="width: 1.75rem; height: 1.75rem; color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem 0;">Pertemuan Langsung</h3>
                            <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.5; margin-bottom: 1.5rem;">
                                Jadwalkan sesi tatap muka untuk diskusi lebih mendalam dengan staf konselor HC.
                            </p>
                        </div>
                        <a href="{{ route('meeting.calendar') }}" style="color: #d97706; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                            PILIH JADWAL &rarr;
                        </a>
                    </div>

                    {{-- Contact Person --}}
                    <div style="background: white; padding: 2rem; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="width: 3.5rem; height: 3.5rem; background-color: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                                <svg style="width: 1.75rem; height: 1.75rem; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem 0;">Contact Person Konseling</h3>
                            <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.5; margin-bottom: 0.75rem;">
                                Hubungi kami untuk informasi lebih lanjut:
                            </p>
                        </div>
                        <a href="https://wa.me/6281234567789" target="_blank" style="display: flex; align-items: center; gap: 0.5rem; color: #064e3b; font-weight: 700; font-size: 1rem; text-decoration: none;">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            0812-3456-7789
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection