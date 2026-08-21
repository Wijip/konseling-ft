@extends('layouts.app')

@section('title', 'Pilih Mode Konseling - Konseling FT UNESA')

@section('content')
    <style>
        .btn-mode-green {
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
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);
            border: none;
        }
        .btn-mode-green:hover {
            background-color: #043e2f;
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.25);
        }
        .btn-mode-amber {
            background-color: #d97706;
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
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.15);
            border: none;
        }
        .btn-mode-amber:hover {
            background-color: #b45309;
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(217, 119, 6, 0.25);
        }
    </style>

    <div style="padding: 3rem 1rem 5rem 1rem; background-color: #f9fafb; min-height: calc(100vh - 160px);">
        <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 1rem;">
            
            {{-- Back Link --}}
            <div style="margin-bottom: 2rem;">
                <a href="{{ route('home') }}" 
                   style="color: #6b7280; text-decoration: none; font-size: 0.875rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;"
                   onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                    ← Kembali ke Beranda
                </a>
            </div>

            {{-- Title Section --}}
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 2.25rem; font-weight: 800; color: #064e3b; margin: 0 0 0.75rem 0;">
                    Pilih Mode Konseling
                </h1>
                <p style="color: #6b7280; font-size: 1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                    Kami menyediakan dua cara untuk berkonsultasi. Pilih metode yang membuat Anda paling nyaman.
                </p>
            </div>

            {{-- Cards Grid --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
                
                {{-- Card 1: Chat Online --}}
                <div class="card" style="background: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 2.5rem 2rem; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        {{-- Icon --}}
                        <div style="width: 4rem; height: 4rem; background-color: #e5e7eb; border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <svg style="width: 2rem; height: 2rem; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>

                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #111827; text-align: center; margin: 0 0 0.75rem 0;">
                            Chat Online
                        </h2>
                        <p style="color: #6b7280; font-size: 0.875rem; text-align: center; line-height: 1.5; margin-bottom: 2rem;">
                            Sampaikan keluhan, kendala, atau hal yang ingin Anda konsultasikan melalui pesan tertulis.
                        </p>

                        {{-- Features List --}}
                        <ul style="list-style: none; padding: 0; margin: 0 0 2.5rem 0; display: flex; flex-direction: column; gap: 1rem;">
                            <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Bisa dikirim selama jam operasional</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Tersedia opsi anonim untuk menjaga privasi</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Riwayat percakapan tersimpan rapi</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Button --}}
                    <a href="{{ route('counseling.identity') }}" class="btn-mode-green">
                        Pilih Chat Online
                    </a>
                </div>

                {{-- Card 2: Pertemuan Langsung --}}
                <div class="card" style="background: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 2.5rem 2rem; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        {{-- Icon --}}
                        <div style="width: 4rem; height: 4rem; background-color: #fef3c7; border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                            <svg style="width: 2rem; height: 2rem; color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #111827; text-align: center; margin: 0 0 0.75rem 0;">
                            Pertemuan Langsung
                        </h2>
                        <p style="color: #6b7280; font-size: 0.875rem; text-align: center; line-height: 1.5; margin-bottom: 2rem;">
                            Atur jadwal sesi tatap muka dengan tim konselor HC untuk pembahasan yang lebih mendalam dan personal.
                        </p>

                        {{-- Features List --}}
                        <ul style="list-style: none; padding: 0; margin: 0 0 2.5rem 0; display: flex; flex-direction: column; gap: 1rem;">
                            <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Interaksi lebih langsung dan terbuka</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Diskusi dua arah yang lebih fokus</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                                <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Cocok untuk pembahasan yang membutuhkan pendampingan</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Button --}}
                    <a href="{{ route('meeting.calendar') }}" class="btn-mode-amber">
                        Jadwalkan Pertemuan
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection