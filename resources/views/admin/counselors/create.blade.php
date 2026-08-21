@extends('admin.layouts.app')

@section('title', 'Tambah Konselor Baru')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.counselors.index') }}" 
           style="color: #6B7280; font-size: 0.875rem; text-decoration: none;" 
           onmouseover="this.style.color='#064e3b'" 
           onmouseout="this.style.color='#6B7280'">← Kembali ke Daftar Konselor</a>
    </div>

    <div style="max-width: 600px; background: white; border-radius: 12px; border: 1px solid #E5E7EB; padding: 2rem 2.25rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <h2 style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1.375rem; color: #064e3b; margin: 0 0 1.75rem 0;">
            Tambah Konselor Baru
        </h2>

        <form action="{{ route('admin.counselors.store') }}" method="POST">
            @csrf

            {{-- Nama --}}
            <div style="margin-bottom: 1.25rem;">
                <label for="name" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Nama Lengkap <span style="color: #dc2626;">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Dr. Budi Santoso, M.Pd."
                       style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                @error('name')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom: 1.25rem;">
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Email <span style="color: #dc2626;">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="konselor@unesa.ac.id"
                       style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                @error('email')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom: 1.75rem;">
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Password <span style="color: #dc2626;">*</span>
                </label>
                <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                       style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 0.95rem; box-sizing: border-box;">
                @error('password')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <button type="submit" 
                        style="flex: 1; background-color: #064e3b; color: white; padding: 0.875rem 1.5rem; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 1rem; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);"
                        onmouseover="this.style.backgroundColor='#043e2f'" 
                        onmouseout="this.style.backgroundColor='#064e3b'">
                    Simpan Konselor
                </button>
                <a href="{{ route('admin.counselors.index') }}" 
                   style="color: #6B7280; text-decoration: none; font-weight: 600; font-size: 0.95rem;"
                   onmouseover="this.style.color='#064e3b'" 
                   onmouseout="this.style.color='#6B7280'">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection