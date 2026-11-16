@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 bg-gray-50/50 min-h-[calc(100vh-160px)]">
    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Form Edit Profil & Unggah Foto -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                <h3 class="text-lg sm:text-xl font-extrabold text-[#064e3b]">
                    Informasi Profil Saya
                </h3>
                <span class="bg-emerald-100 text-[#064e3b] px-3 py-1 rounded-full font-bold text-xs">
                    {{ ucfirst($user->role ?? 'Pengguna') }}
                </span>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Foto Avatar Upload Area -->
                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 bg-slate-50/70 rounded-2xl border border-slate-100">
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-4 border-white bg-[#064e3b] shadow-md flex items-center justify-center text-white font-extrabold text-2xl sm:text-3xl">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                    </div>
                    <div class="flex-1 text-center sm:text-left space-y-2">
                        <label for="avatar" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white text-xs sm:text-sm font-bold rounded-xl cursor-pointer transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Pilih Foto Baru</span>
                        </label>
                        <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" onchange="this.form.submit()">
                        <p class="text-xs text-gray-400">Format: JPG, PNG, atau GIF. Maksimal 2MB.</p>
                        @error('avatar')
                            <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Input Data Diri -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2.5 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIM / NIP -->
                    <div>
                        <label for="nim_nip" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">NIM / NIP</label>
                        <input type="text" name="nim_nip" id="nim_nip" value="{{ old('nim_nip', $user->nim_nip ?? '') }}" placeholder="Masukkan NIM atau NIP"
                            class="w-full px-4 py-2.5 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                        @error('nim_nip')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rumpun -->
                    <div>
                        <label for="rumpun" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Rumpun</label>
                        <input type="text" name="rumpun" id="rumpun" value="{{ old('rumpun', $user->rumpun ?? '') }}" placeholder="Contoh: Teknik Informatika"
                            class="w-full px-4 py-2.5 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                        @error('rumpun')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No WhatsApp / HP -->
                    <div class="sm:col-span-2">
                        <label for="phone_number" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">No. WhatsApp / HP</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Contoh: 081234567890"
                            class="w-full px-4 py-2.5 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                        @error('phone_number')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Detail Pendaftaran & Aktivitas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-500 block mb-1">Terdaftar Sejak</span>
                        <strong class="text-gray-900 text-sm sm:text-base font-bold">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</strong>
                    </div>
                    <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-500 block mb-1">Total Aktivitas Konseling</span>
                        <strong class="text-[#064e3b] text-sm sm:text-base font-bold">{{ $totalCounseling }} Kali Konsultasi</strong>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md cursor-pointer">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Form Ganti Password -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h3 class="text-lg sm:text-xl font-extrabold text-[#064e3b] mb-6 border-b border-gray-100 pb-4">
                Ganti Password Akun
            </h3>

            <form action="{{ route('profile.updatePassword') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Password Saat Ini <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password" required placeholder="Masukkan password yang digunakan sekarang"
                            class="w-full px-4 py-2.5 pr-11 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                        <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 cursor-pointer flex items-center justify-center transition-colors"
                            data-target="current_password" aria-label="Tampilkan atau sembunyikan password saat ini">
                            <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 pr-11 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                            <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 cursor-pointer flex items-center justify-center transition-colors"
                                data-target="password" aria-label="Tampilkan atau sembunyikan password baru">
                                <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password baru"
                                class="w-full px-4 py-2.5 pr-11 text-xs sm:text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white">
                            <button type="button" class="toggle-password-btn absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1 cursor-pointer flex items-center justify-center transition-colors"
                                data-target="password_confirmation" aria-label="Tampilkan atau sembunyikan konfirmasi password baru">
                                <svg class="eye-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md cursor-pointer">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Ringkasan Konseling Section -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-base sm:text-lg font-extrabold text-gray-900 mb-4">Ringkasan Konseling</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="border border-gray-100 p-4 rounded-xl bg-white shadow-xs">
                    <span class="text-xs sm:text-sm text-gray-500 font-medium">Konseling Chat Online</span>
                    <div class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ $totalChat }}</div>
                </div>
                <div class="border border-gray-100 p-4 rounded-xl bg-white shadow-xs">
                    <span class="text-xs sm:text-sm text-gray-500 font-medium">Booking Pertemuan</span>
                    <div class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ $totalMeetings }}</div>
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('history') }}" 
                    class="inline-flex items-center gap-2 px-5 py-3 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl font-bold text-xs sm:text-sm transition-all shadow-md hover:shadow-lg">
                    <span>Lihat Seluruh Riwayat Konseling</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection