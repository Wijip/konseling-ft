@extends('layouts.app')

@section('title', 'Form Konseling - Konseling FT UNESA')

@section('content')
    <div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-[calc(100vh-160px)] flex items-center justify-center">
        <div class="w-full max-w-2xl mx-auto">
            
            {{-- Card Utama --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 sm:p-10">
                
                {{-- Header --}}
                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#064e3b] mb-2">
                        {{ $type === 'anonymous' ? 'Konseling Anonim' : 'Form Konseling' }}
                    </h1>
                    <p class="text-gray-500 text-sm sm:text-base leading-relaxed">
                        {{ $type === 'anonymous' ? 'Anda tidak perlu mengisi data diri. Langsung sampaikan keluhan Anda.' : 'Lengkapi data diri Anda untuk memulai konseling.' }}
                    </p>
                </div>

                <form action="{{ route('counseling.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="identity_type" value="{{ $type }}">

                    @if($type === 'open')
                        <!-- Data Diri -->
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

                        <!-- Form Status Civitas -->
                        <div>
                            <label for="user_status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="user_status" id="user_status"
                                class="w-full px-4 py-3 border rounded-xl text-sm bg-white transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('user_status') border-red-500 @else border-gray-300 @enderror"
                                required>
                                <option value="" disabled selected>Pilih Status...</option>
                                <option value="Dosen" {{ old('user_status') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="Karyawan" {{ old('user_status') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                <option value="Mahasiswa" {{ old('user_status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            </select>
                            @error('user_status')
                                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="employee_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Induk (NIM/NIP/NIDN) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}"
                                class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('employee_id') border-red-500 @else border-gray-300 @enderror"
                                placeholder="Contoh: 12345678" required>
                            @error('employee_id')
                                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Nomor HP / WhatsApp --}}
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

                        <!-- Form Rumpun -->
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

                        <!-- Form Prodi -->
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

                        <hr class="border-gray-200 my-6">
                    @endif

                    <!-- Detail Masalah -->
                    <div>
                        <label for="topic" class="block text-sm font-semibold text-gray-700 mb-2">
                            Topik Konseling <span class="text-red-500">*</span>
                        </label>
                        <select name="topic" id="topic"
                            class="w-full px-4 py-3 border rounded-xl text-sm bg-white transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('topic') border-red-500 @else border-gray-300 @enderror"
                            required>
                            <option value="" disabled selected>Pilih topik yang sesuai...</option>
                            <option value="Akademik" {{ old('topic') == 'Akademik' ? 'selected' : '' }}>Masalah Akademik / Kuliah</option>
                            <option value="Pekerjaan" {{ old('topic') == 'Pekerjaan' ? 'selected' : '' }}>Masalah Pekerjaan / Karir</option>
                            <option value="Keluarga" {{ old('topic') == 'Keluarga' ? 'selected' : '' }}>Masalah Keluarga / Pribadi</option>
                            <option value="Hubungan" {{ old('topic') == 'Hubungan' ? 'selected' : '' }}>Hubungan dengan Rekan/Teman</option>
                            <option value="Stress" {{ old('topic') == 'Stress' ? 'selected' : '' }}>Stress / Burnout</option>
                            <option value="Lainnya" {{ old('topic') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('topic')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Sudah berapa lama masalah ini berlangsung? <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="border border-gray-300 hover:border-[#064e3b] p-3 rounded-xl cursor-pointer flex items-center gap-2.5 text-sm text-gray-700 transition-all">
                                <input type="radio" name="duration" value="< 1 minggu" {{ old('duration') == '< 1 minggu' ? 'checked' : '' }} class="w-4 h-4 text-[#064e3b] focus:ring-[#064e3b] accent-[#064e3b]" required>
                                <span>Baru terjadi (&lt; 1 minggu)</span>
                            </label>
                            <label class="border border-gray-300 hover:border-[#064e3b] p-3 rounded-xl cursor-pointer flex items-center gap-2.5 text-sm text-gray-700 transition-all">
                                <input type="radio" name="duration" value="1-4 minggu" {{ old('duration') == '1-4 minggu' ? 'checked' : '' }} class="w-4 h-4 text-[#064e3b] focus:ring-[#064e3b] accent-[#064e3b]">
                                <span>1-4 minggu</span>
                            </label>
                            <label class="border border-gray-300 hover:border-[#064e3b] p-3 rounded-xl cursor-pointer flex items-center gap-2.5 text-sm text-gray-700 transition-all">
                                <input type="radio" name="duration" value="1-3 bulan" {{ old('duration') == '1-3 bulan' ? 'checked' : '' }} class="w-4 h-4 text-[#064e3b] focus:ring-[#064e3b] accent-[#064e3b]">
                                <span>1-3 bulan</span>
                            </label>
                            <label class="border border-gray-300 hover:border-[#064e3b] p-3 rounded-xl cursor-pointer flex items-center gap-2.5 text-sm text-gray-700 transition-all">
                                <input type="radio" name="duration" value="> 3 bulan" {{ old('duration') == '> 3 bulan' ? 'checked' : '' }} class="w-4 h-4 text-[#064e3b] focus:ring-[#064e3b] accent-[#064e3b]">
                                <span>Lebih dari 3 bulan</span>
                            </label>
                        </div>
                        @error('duration')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="issue_description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Apa yang ingin Anda konsultasikan? <span class="text-red-500">*</span>
                        </label>
                        <textarea name="issue_description" id="issue_description" rows="5"
                            class="w-full px-4 py-3 border rounded-xl text-sm transition-all focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 @error('issue_description') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Tuliskan keluhan atau hal yang ingin Anda konsultasikan..."
                            required>{{ old('issue_description') }}</textarea>
                        @error('issue_description')
                            <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="text-[11px] text-gray-400 text-right mt-1">Maksimal 2000 karakter</p>
                    </div>

                    {{-- Information Alert --}}
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-[#064e3b]">
                        <p class="font-bold text-sm mb-1">Informasi:</p>
                        <p class="text-xs sm:text-sm leading-relaxed text-[#043e2f]">
                            Setelah mengirim, Anda akan mendapatkan kode tracking unik untuk mengakses ruang chat konseling.
                        </p>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="flex-1 bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-center text-sm sm:text-base cursor-pointer">
                            Mulai Konseling
                        </button>
                        <a href="{{ route('counseling.identity') }}"
                            class="text-gray-500 hover:text-[#064e3b] font-semibold text-sm px-4 py-3.5 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection