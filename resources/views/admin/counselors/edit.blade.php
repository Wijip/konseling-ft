@extends('admin.layouts.app')

@section('title', 'Edit Data Konselor')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
        
        <!-- Header & Back Button -->
        <div class="flex items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h3 class="font-extrabold text-lg sm:text-xl text-slate-900">Edit Profil Konselor</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Perbarui informasi akun konselor {{ $counselor->name }}.</p>
            </div>
            <a href="{{ route('admin.counselors.index') }}" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs sm:text-sm font-bold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Form Edit Konselor -->
        <form action="{{ route('admin.counselors.update', $counselor->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Konselor -->
            <div>
                <label for="name" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Nama Konselor <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $counselor->name) }}"
                       class="w-full px-4 py-2.5 rounded-xl border @error('name') border-red-300 bg-red-50/30 @else border-slate-200 @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] transition-all"
                       placeholder="Masukkan nama lengkap konselor"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Konselor -->
            <div>
                <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Alamat Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email', $counselor->email) }}"
                       class="w-full px-4 py-2.5 rounded-xl border @error('email') border-red-300 bg-red-50/30 @else border-slate-200 @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] transition-all"
                       placeholder="contoh@unesa.ac.id"
                       required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div>
                <label for="password" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Password Baru <span class="text-slate-400 font-normal">(Opsional)</span>
                </label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="w-full px-4 py-2.5 rounded-xl border @error('password') border-red-300 bg-red-50/30 @else border-slate-200 @enderror text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 focus:border-[#064e3b] transition-all"
                       placeholder="Kosongkan jika tidak ingin mengubah password">
                <p class="text-slate-400 text-[11px] mt-1">Minimal 8 karakter jika diisi.</p>
                @error('password')
                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.counselors.index') }}" 
                   class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 text-xs sm:text-sm font-bold transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md hover:shadow-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection