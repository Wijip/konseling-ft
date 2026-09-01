@extends('layouts.app')

@section('title', 'Form Booking Pertemuan')

@section('content')
    <div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-[calc(100vh-160px)] flex items-center justify-center">
        <div class="w-full max-w-2xl mx-auto">
            
            {{-- Back Link --}}
            <div class="mb-6">
                <a href="{{ route('meeting.calendar') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#064e3b] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Pilih Jadwal
                </a>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 sm:p-10">
                
                {{-- Schedule Detail Card --}}
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-2xl p-5 sm:p-6 mb-8 border border-emerald-200 relative overflow-hidden">
                    <div class="absolute -top-5 -right-5 w-24 h-24 bg-[#064e3b]/5 rounded-full"></div>
                    <div class="absolute -bottom-6 right-10 w-16 h-16 bg-emerald-500/10 rounded-full"></div>

                    <h3 class="font-extrabold text-[#064e3b] mb-4 flex items-center gap-2 text-base relative z-10">
                        <svg class="w-5 h-5 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Detail Jadwal Terpilih
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-4 text-xs sm:text-sm relative z-10">
                        <div>
                            <span class="text-emerald-700 block mb-1 text-[11px] uppercase tracking-wider font-bold">Tanggal</span>
                            <p class="font-bold text-[#064e3b] m-0">{{ $schedule->schedule_date->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div>
                            <span class="text-emerald-700 block mb-1 text-[11px] uppercase tracking-wider font-bold">Waktu</span>
                            <p class="font-bold text-[#064e3b] m-0">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                            </p>
                        </div>
                        <div>
                            <span class="text-emerald-700 block mb-1 text-[11px] uppercase tracking-wider font-bold">Konselor</span>
                            <p class="font-bold text-[#064e3b] m-0">{{ $schedule->konselor_name ?? ($schedule->konselor->name ?? 'Tim HC') }}</p>
                        </div>
                        <div>
                            <span class="text-emerald-700 block mb-1 text-[11px] uppercase tracking-wider font-bold">Sisa Slot</span>
                            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full mt-0.5">
                                {{ $schedule->max_slots - $schedule->booked_slots }} tersedia
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Form Header --}}
                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#064e3b] mb-2">Form Booking Pertemuan</h1>
                    <p class="text-gray-500 text-sm sm:text-base leading-relaxed">Lengkapi data diri Anda untuk melakukan booking.</p>
                </div>

                <form action="{{ route('meeting.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="meeting_schedule_id" value="{{ $schedule->id }}">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('name') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email (Untuk Notifikasi) <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('email') border-red-500 @else border-gray-300 @enderror"
                            placeholder="nama@email.com" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor HP / WhatsApp --}}
                    <div>
                        <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor HP / WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                            class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('phone_number') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Contoh: 081234567890" required>
                        @error('phone_number')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Dropdown --}}
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status"
                            class="w-full px-4 py-3 border rounded-xl text-sm bg-white transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('status') border-red-500 @else border-gray-300 @enderror"
                            required>
                            <option value="" disabled selected>Pilih Status...</option>
                            <option value="Dosen" {{ old('status') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="Karyawan" {{ old('status') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                            <option value="Mahasiswa" {{ old('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIP / NIM --}}
                    <div>
                        <label for="employee_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            NIP / NIM <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}"
                            class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('employee_id') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Contoh: 12345678" required>
                        @error('employee_id')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rumpun Dropdown --}}
                    <div>
                        <label for="rumpun" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rumpun <span class="text-red-500">*</span>
                        </label>
                        <select name="rumpun" id="rumpun"
                            class="w-full px-4 py-3 border rounded-xl text-sm bg-white transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('rumpun') border-red-500 @else border-gray-300 @enderror"
                            required>
                            <option value="" disabled selected>Pilih Rumpun...</option>
                            @foreach(['PKK', 'Sipil', 'Elektro', 'Mesin', 'Informatika'] as $rmp)
                                <option value="{{ $rmp }}" {{ old('rumpun') == $rmp ? 'selected' : '' }}>{{ $rmp }}</option>
                            @endforeach
                        </select>
                        @error('rumpun')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Program Studi (Prodi) --}}
                    <div>
                        <label for="prodi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Program Studi (Prodi) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}"
                            class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('prodi') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Contoh: Sistem Informasi" required>
                        @error('prodi')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipe Pertemuan --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Tipe Pertemuan <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Offline -->
                            <label class="border border-gray-300 hover:border-[#064e3b] hover:bg-emerald-50/50 p-4 rounded-xl cursor-pointer flex items-center gap-3 transition-all bg-white">
                                <input type="radio" name="meeting_type" value="offline" {{ old('meeting_type', 'offline') == 'offline' ? 'checked' : '' }} required
                                    class="w-5 h-5 text-[#064e3b] focus:ring-[#064e3b] accent-[#064e3b]">
                                <div>
                                    <span class="block font-bold text-sm text-gray-900">Pertemuan Langsung</span>
                                    <span class="block text-xs text-gray-500">Hadir di ruangan konseling</span>
                                </div>
                            </label>

                            <!-- Online -->
                            <label class="border border-gray-300 hover:border-[#064e3b] hover:bg-emerald-50/50 p-4 rounded-xl cursor-pointer flex items-center gap-3 transition-all bg-white">
                                <input type="radio" name="meeting_type" value="online" {{ old('meeting_type') == 'online' ? 'checked' : '' }}
                                    class="w-5 h-5 text-[#064e3b] focus:ring-[#064e3b] accent-[#064e3b]">
                                <div>
                                    <span class="block font-bold text-sm text-gray-900">Online (Zoom)</span>
                                    <span class="block text-xs text-gray-500">Link akan dikirim via tracking</span>
                                </div>
                            </label>
                        </div>
                        @error('meeting_type')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-200 my-6">

                    {{-- Topik --}}
                    <div>
                        <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-2">
                            Topik yang Ingin Dibahas <span class="text-red-500">*</span>
                        </label>
                        <textarea name="purpose" id="purpose" rows="4"
                            class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('purpose') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Jelaskan secara singkat topik atau masalah yang ingin Anda konsultasikan..."
                            required>{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="text-[11px] text-gray-400 text-right mt-1">Maksimal 2000 karakter</p>
                    </div>

                    {{-- Info Alert --}}
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-[#064e3b]">
                        <p class="font-bold text-sm mb-1">Informasi:</p>
                        <p class="text-xs sm:text-sm leading-relaxed text-[#043e2f]">
                            Setelah booking, status pengajuan Anda akan <strong>Pending</strong> menunggu konfirmasi admin. Cek status secara berkala menggunakan kode tracking.
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="flex-1 bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-center text-sm sm:text-base cursor-pointer">
                            Booking Sekarang
                        </button>
                        <a href="{{ route('meeting.calendar') }}"
                            class="text-gray-500 hover:text-[#064e3b] font-semibold text-sm px-4 py-3.5 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection