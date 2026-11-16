@extends('admin.layouts.app')

@section('title', 'Tambah Konselor Baru')
@section('header_title', 'Tambah Konselor Baru')
@section('header_subtitle', 'Formulir pendaftaran akun konselor baru.')

@section('content')
    <!-- Back Link -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.counselors.index') }}" 
            class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-[#064e3b] transition-colors">
            &larr; Kembali ke Daftar Konselor
        </a>
    </div>

    <!-- Form Card Container -->
    <div class="max-w-xl bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
        <h2 class="text-xl sm:text-2xl font-extrabold text-[#064e3b] tracking-tight mb-6">
            Tambah Konselor Baru
        </h2>

        <form action="{{ route('admin.counselors.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-red-600">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Dr. Budi Santoso, M.Pd."
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all placeholder-slate-400 @error('name') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                @error('name')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Email <span class="text-red-600">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="konselor@unesa.ac.id"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all placeholder-slate-400 @error('email') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                @error('email')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- No. WhatsApp / HP --}}
            <div>
                <label for="phone_number" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    No. WhatsApp / HP
                </label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" placeholder="Contoh: 081234567890"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all placeholder-slate-400 @error('phone_number') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                @error('phone_number')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Password <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                        class="w-full px-3.5 py-2.5 pr-11 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all placeholder-slate-400 @error('password') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                    <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 cursor-pointer flex items-center justify-center transition-colors"
                        data-target="password" aria-label="Tampilkan atau sembunyikan password">
                        <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit & Cancel Buttons --}}
            <div class="flex items-center gap-4 pt-3">
                <button type="submit" 
                    class="flex-1 py-3 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md hover:shadow-lg cursor-pointer">
                    Simpan Konselor
                </button>
                <a href="{{ route('admin.counselors.index') }}" 
                    class="px-4 py-3 text-slate-500 hover:text-[#064e3b] text-xs sm:text-sm font-bold transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection