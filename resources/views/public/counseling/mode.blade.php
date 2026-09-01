@extends('layouts.app')

@section('title', 'Pilih Mode Konseling - Konseling FT UNESA')

@section('content')
    <div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-[calc(100vh-160px)]">
        <div class="max-w-4xl mx-auto">
            
            {{-- Back Link --}}
            <div class="mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#064e3b] transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>

            {{-- Title Section --}}
            <div class="text-center mb-10 sm:mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#064e3b] mb-3">
                    Pilih Mode Konseling
                </h1>
                <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                    Kami menyediakan dua cara untuk berkonsultasi. Pilih metode yang membuat Anda paling nyaman.
                </p>
            </div>

            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                
                {{-- Card 1: Chat Online --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-10 flex flex-col justify-between">
                    <div>
                        {{-- Icon --}}
                        <div class="w-16 h-16 bg-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>

                        <h2 class="text-2xl font-extrabold text-gray-900 text-center mb-3">
                            Chat Online
                        </h2>
                        <p class="text-gray-500 text-sm text-center leading-relaxed mb-8">
                            Sampaikan keluhan, kendala, atau hal yang ingin Anda konsultasikan melalui pesan tertulis.
                        </p>

                        {{-- Features List --}}
                        <ul class="space-y-4 mb-10">
                            <li class="flex items-start gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Bisa dikirim selama jam operasional</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Tersedia opsi anonim untuk menjaga privasi</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Riwayat percakapan tersimpan rapi</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Button --}}
                    <a href="{{ route('counseling.identity') }}" class="w-full bg-[#064e3b] hover:bg-[#04382a] text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-center text-base inline-block">
                        Pilih Chat Online
                    </a>
                </div>

                {{-- Card 2: Pertemuan Langsung --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-10 flex flex-col justify-between">
                    <div>
                        {{-- Icon --}}
                        <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <h2 class="text-2xl font-extrabold text-gray-900 text-center mb-3">
                            Pertemuan Langsung
                        </h2>
                        <p class="text-gray-500 text-sm text-center leading-relaxed mb-8">
                            Atur jadwal sesi tatap muka dengan tim konselor HC untuk pembahasan yang lebih mendalam dan personal.
                        </p>

                        {{-- Features List --}}
                        <ul class="space-y-4 mb-10">
                            <li class="flex items-start gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Interaksi lebih langsung dan terbuka</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Diskusi dua arah yang lebih fokus</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Cocok untuk pembahasan yang membutuhkan pendampingan</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Button --}}
                    <a href="{{ route('meeting.calendar') }}" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-center text-base inline-block">
                        Jadwalkan Pertemuan
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection