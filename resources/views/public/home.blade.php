@extends('layouts.app')

@section('title', 'Beranda - Layanan Konseling Fakultas Teknik')

@section('content')
    <div class="w-full">
        {{-- Hero Section --}}
        <div class="relative w-full min-h-[500px] lg:min-h-[560px] bg-white overflow-hidden flex items-center py-10 lg:py-14">
            
            {{-- Background Image (Sisi Kanan di Desktop, Transparan di Mobile) --}}
            <div class="absolute top-0 right-0 lg:-right-10 w-full lg:w-[68%] h-full z-10 opacity-20 lg:opacity-100 pointer-events-none lg:pointer-events-auto">
                <img src="{{ asset('images/landing-hero.png') }}" alt="Gedung FT UNESA" class="w-full h-full object-cover object-center lg:object-right">
                
                {{-- Fade Gradient Mask (Transisi Sisi Kiri) --}}
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 lg:via-white/85 to-transparent"></div>
            </div>

            {{-- Content Area --}}
            <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-lg">
                    
                    {{-- Badge --}}
                    <div class="inline-block px-5 py-1.5 bg-gray-200 text-gray-600 rounded-full text-xs font-bold tracking-wider mb-6 uppercase">
                        Layanan Konseling Fakultas Teknik
                    </div>

                    {{-- Main Title --}}
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#064e3b] leading-[1.05] mb-4 tracking-tight">
                        COUNSELING<br>CORNER
                    </h1>

                    {{-- Yellow Accent Line --}}
                    <div class="w-12 h-1 bg-amber-500 mb-6 rounded-sm"></div>

                    {{-- Description --}}
                    <p class="text-gray-700 text-sm sm:text-base leading-relaxed font-medium mb-8">
                        Karena Kesehatan Mental Anda Penting. Di sini, Anda bisa berbicara dengan aman, didengar, dan didampingi secara profesional untuk menghadapi setiap tantangan.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center">
                        <a href="{{ route('counseling.mode') }}" class="inline-flex items-center justify-center gap-2.5 bg-[#064e3b] hover:bg-[#04382a] text-white px-7 py-3.5 rounded-full font-bold text-sm shadow-md transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Mulai Konseling
                        </a>

                        <a href="{{ route('tracking.index') }}" class="inline-flex items-center justify-center gap-2.5 bg-white hover:bg-gray-50 text-[#064e3b] border border-gray-300 px-7 py-3.5 rounded-full font-bold text-sm transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Cek Status
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features Section --}}
        <div class="bg-gray-50 py-12 lg:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    
                    {{-- Chat Online --}}
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 bg-gray-200 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Chat Online</h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                                Konseling tertulis yang fleksibel. Tersedia opsi anonim untuk privasi maksimal.
                            </p>
                        </div>
                        <a href="{{ route('counseling.mode') }}" class="text-[#064e3b] hover:text-[#04382a] font-bold text-sm inline-flex items-center gap-2">
                            PILIH LAYANAN &rarr;
                        </a>
                    </div>

                    {{-- Pertemuan Langsung --}}
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Pertemuan Langsung</h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                                Jadwalkan sesi tatap muka untuk diskusi lebih mendalam dengan staf konselor HC.
                            </p>
                        </div>
                        <a href="{{ route('meeting.calendar') }}" class="text-amber-600 hover:text-amber-700 font-bold text-sm inline-flex items-center gap-2">
                            PILIH JADWAL &rarr;
                        </a>
                    </div>

                    {{-- Contact Person --}}
                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 bg-gray-200 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Contact Person Konseling</h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-3">
                                Hubungi kami untuk informasi lebih lanjut:
                            </p>
                        </div>
                        <a href="https://wa.me/6281234567789" target="_blank" class="flex items-center gap-2 text-[#064e3b] hover:text-[#04382a] font-bold text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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