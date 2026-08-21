@extends('admin.layouts.app')

@section('content')
    <div
        style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 60vh; text-align: center; padding: 2rem;">
        <div style="font-size: 6rem; font-weight: 800; color: #E5E7EB; line-height: 1;">403</div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 1rem;">Akses Ditolak</h1>
        <p style="color: #6B7280; margin-top: 0.5rem; max-width: 400px;">Maaf, Anda tidak memiliki izin untuk mengakses
            halaman ini.</p>
        <a href="{{ url('/') }}"
            style="margin-top: 1.5rem; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background: #DC2626; color: #fff; border-radius: 0.5rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: background 0.15s;"
            onmouseover="this.style.background='#B91C1C'" onmouseout="this.style.background='#DC2626'">
            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Kembali ke Beranda
        </a>
    </div>
@endsection