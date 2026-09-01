@extends('layouts.app')

@section('title', 'Cek Status Layanan')

@section('content')
    <div class="py-12 px-4 bg-gray-50 min-h-[calc(100vh-80px-180px)] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto">
            
            {{-- Card Utama --}}
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-xl text-center">
                
                {{-- Icon Kaca Pembesar --}}
                <div class="w-16 h-16 bg-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                
                <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Cek Status Layanan</h1>
                <p class="text-sm text-gray-500 mb-8">
                    Masukkan kode tracking untuk melihat status konseling atau jadwal pertemuan Anda.
                </p>

                <form action="{{ route('tracking.check') }}" method="POST">
                    @csrf
                    <div class="mb-6 text-left">
                        <label for="tracking_code" class="block text-sm font-semibold text-gray-700 mb-2 text-center">
                            Kode Tracking
                        </label>
                        <input type="text" name="tracking_code" id="tracking_code" value="{{ old('tracking_code') }}"
                            class="w-full text-center text-lg font-mono tracking-widest uppercase bg-white px-4 py-3 border rounded-xl transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('tracking_code') border-red-500 @else border-gray-300 @enderror"
                            placeholder="CS-XXXXXXXX" required autocomplete="off" autofocus>
                        @error('tracking_code')
                            <p class="text-red-500 text-xs mt-2 text-center font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Lacak Status --}}
                    <button type="submit" class="w-full bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all text-base cursor-pointer">
                        Lacak Status
                    </button>

                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-[#064e3b] transition-colors">
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>

            {{-- Info Alert --}}
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-800 leading-relaxed">
                <p>
                    <strong>Info:</strong> Kode tracking adalah kunci akses rahasia Anda. Jangan bagikan kepada orang lain yang tidak berkepentingan.
                </p>
            </div>
        </div>
    </div>
@endsection