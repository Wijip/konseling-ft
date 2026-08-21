@extends('layouts.app')

@section('title', 'Cek Status Layanan')

@section('content')
    <style>
        .form-input:focus {
            border-color: #064e3b !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.15) !important;
        }
        .btn-green-submit {
            background-color: #064e3b;
            color: #ffffff;
            width: 100%;
            border: none;
            padding: 0.875rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-green-submit:hover {
            background-color: #043e2f;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
        }
    </style>

    <div style="padding: 3rem 1rem; background-color: #f9fafb; min-height: calc(100vh - 80px - 180px);">
        <div style="max-width: 28rem; margin: 0 auto; padding: 0 1rem;">
            <div class="card" style="border-radius: 2rem; text-align: center; background: #ffffff; padding: 2.5rem 2rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                
                {{-- Icon Kaca Pembesar (Warna Hijau UNESA) --}}
                <div
                    style="width: 4rem; height: 4rem; background-color: #e5e7eb; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <svg style="width: 2rem; height: 2rem; color: #064e3b;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                
                <h1 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin-bottom: 0.5rem;">Cek Status Layanan
                </h1>
                <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 2rem;">
                    Masukkan kode tracking untuk melihat status konseling atau jadwal pertemuan Anda.
                </p>

                <form action="{{ route('tracking.check') }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1.5rem; text-align: left;">
                        <label for="tracking_code" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; text-align: center;">
                            Kode Tracking
                        </label>
                        <input type="text" name="tracking_code" id="tracking_code" value="{{ old('tracking_code') }}"
                            class="form-input @error('tracking_code') border-red-500 @enderror"
                            style="width: 100%; text-align: center; font-size: 1.125rem; letter-spacing: 0.2em; font-family: 'Courier New', monospace; text-transform: uppercase; background-color: #ffffff; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem;"
                            placeholder="CS-XXXXXXXX" required autocomplete="off" autofocus>
                        @error('tracking_code')
                            <p class="form-error text-center" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Lacak Status (Hijau) --}}
                    <button type="submit" class="btn-green-submit">
                        Lacak Status
                    </button>

                    <div style="text-align: center; margin-top: 1.5rem;">
                        <a href="{{ route('home') }}" style="font-size: 0.875rem; color: #6b7280; text-decoration: none; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>

            <div class="alert alert-info" style="margin-top: 1.5rem; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.75rem; padding: 1rem 1.25rem; font-size: 0.875rem; color: #1e40af; line-height: 1.5;">
                <p style="font-size: 0.875rem; margin: 0;">
                    <strong>Info:</strong> Kode tracking adalah kunci akses rahasia Anda. Jangan bagikan kepada orang lain
                    yang tidak berkepentingan.
                </p>
            </div>
        </div>
    </div>
@endsection