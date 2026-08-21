@extends('layouts.app')

@section('title', 'Form Booking Pertemuan')

@section('content')
    <style>
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #064e3b !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.15) !important;
        }
        .btn-green-submit {
            background-color: #064e3b !important;
            color: #ffffff !important;
            border: none;
            padding: 0.875rem 1.75rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
            width: 100%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        .btn-green-submit:hover {
            background-color: #043e2f !important;
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.3);
        }
        .radio-card-option:hover {
            border-color: #064e3b !important;
            background-color: #f0fdf4 !important;
        }
    </style>

    <div style="padding: 3rem 1rem; min-height: calc(100vh - 80px - 180px); background-color: #f9fafb;">
        <div class="form-container" style="max-width: 42rem; margin: 0 auto;">
            
            {{-- Back Link --}}
            <div style="margin-bottom: 1.5rem;">
                <a href="{{ route('meeting.calendar') }}"
                    style="color: #6b7280; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; font-weight: 500;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Pilih Jadwal
                </a>
            </div>

            <div class="card" style="background: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 2.5rem 2rem;">
                
                {{-- Schedule Detail Card --}}
                <div style="background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%); border-radius: 1rem; padding: 1.75rem; margin-bottom: 2rem; border: 1px solid #a7f3d0; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(6, 78, 59, 0.05); border-radius: 50%;"></div>
                    <div style="position: absolute; bottom: -30px; right: 40px; width: 60px; height: 60px; background: rgba(16, 185, 129, 0.05); border-radius: 50%;"></div>

                    <h3 style="font-weight: 700; color: #064e3b; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Detail Jadwal
                    </h3>
                    <div class="schedule-detail-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; font-size: 0.875rem;">
                        <div>
                            <span style="color: #047857; display: block; margin-bottom: 0.25rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Tanggal</span>
                            <p style="font-weight: 700; color: #064e3b; margin: 0;">{{ $schedule->schedule_date->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div>
                            <span style="color: #047857; display: block; margin-bottom: 0.25rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Waktu</span>
                            <p style="font-weight: 700; color: #064e3b; margin: 0;">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                            </p>
                        </div>
                        <div>
                            <span style="color: #047857; display: block; margin-bottom: 0.25rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Konselor</span>
                            <p style="font-weight: 700; color: #064e3b; margin: 0;">{{ $schedule->konselor_name ?? ($schedule->konselor->name ?? 'Tim HC') }}</p>
                        </div>
                        <div>
                            <span style="color: #047857; display: block; margin-bottom: 0.25rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Sisa Slot</span>
                            <span style="display: inline-block; padding: 0.25rem 0.75rem; background-color: #d1fae5; color: #065f46; font-size: 0.75rem; font-weight: 700; border-radius: 9999px; margin-top: 0.25rem;">
                                {{ $schedule->max_slots - $schedule->booked_slots }} tersedia
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Form Header --}}
                <div class="card-header" style="margin-bottom: 2rem; border-bottom: 1px solid #f3f4f6; padding-bottom: 1.5rem;">
                    <h1 class="card-title" style="font-size: 1.875rem; font-weight: 800; color: #064e3b; margin: 0 0 0.5rem 0;">Form Booking Pertemuan</h1>
                    <p style="color: #6b7280; font-size: 0.95rem; margin: 0; line-height: 1.5;">Lengkapi data diri Anda untuk melakukan booking.</p>
                </div>

                <form action="{{ route('meeting.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="meeting_schedule_id" value="{{ $schedule->id }}">

                    {{-- Nama Lengkap --}}
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="name" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Nama Lengkap <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="form-input @error('name') border-red-500 @enderror"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                            placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="email" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Email (Untuk Notifikasi) <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-input @error('email') border-red-500 @enderror" 
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                            placeholder="nama@email.com" required>
                        @error('email')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor HP / WhatsApp --}}
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="phone_number" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Nomor HP / WhatsApp <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                            class="form-input @error('phone_number') border-red-500 @enderror"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                            placeholder="Contoh: 081234567890" required>
                        @error('phone_number')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Dropdown --}}
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="status" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Status <span style="color: #dc2626;">*</span>
                        </label>
                        <select name="status" id="status" class="form-select @error('status') border-red-500 @enderror" 
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem; background-color: #ffffff;" required>
                            <option value="" disabled selected>Pilih Status...</option>
                            <option value="Dosen" {{ old('status') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="Karyawan" {{ old('status') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                            <option value="Mahasiswa" {{ old('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                        @error('status')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIP / NIM --}}
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="employee_id" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            NIP / NIM <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}"
                            class="form-input @error('employee_id') border-red-500 @enderror"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                            placeholder="Contoh: 12345678" required>
                        @error('employee_id')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rumpun Dropdown --}}
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="rumpun" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Rumpun <span style="color: #dc2626;">*</span>
                        </label>
                        <select name="rumpun" id="rumpun" class="form-select @error('rumpun') border-red-500 @enderror" 
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem; background-color: #ffffff;" required>
                            <option value="" disabled selected>Pilih Rumpun...</option>
                            @foreach(['PKK', 'Sipil', 'Elektro', 'Mesin', 'Informatika'] as $rmp)
                                <option value="{{ $rmp }}" {{ old('rumpun') == $rmp ? 'selected' : '' }}>{{ $rmp }}</option>
                            @endforeach
                        </select>
                        @error('rumpun')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Program Studi (Prodi) --}}
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="prodi" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Program Studi (Prodi) <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}"
                            class="form-input @error('prodi') border-red-500 @enderror"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                            placeholder="Contoh: Sistem Informasi" required>
                        @error('prodi')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipe Pertemuan --}}
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.75rem;">
                            Tipe Pertemuan <span style="color: #dc2626;">*</span>
                        </label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <!-- Offline -->
                            <label class="radio-card-option" style="padding: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.75rem; transition: all 0.2s; background: white;">
                                <input type="radio" name="meeting_type" value="offline" {{ old('meeting_type', 'offline') == 'offline' ? 'checked' : '' }} required
                                    style="width: 1.25rem; height: 1.25rem; accent-color: #064e3b;">
                                <div>
                                    <span style="display: block; font-weight: 700; font-size: 0.875rem; color: #111827;">Pertemuan Langsung</span>
                                    <span style="display: block; font-size: 0.75rem; color: #6b7280;">Hadir di ruangan konseling</span>
                                </div>
                            </label>

                            <!-- Online -->
                            <label class="radio-card-option" style="padding: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.75rem; transition: all 0.2s; background: white;">
                                <input type="radio" name="meeting_type" value="online" {{ old('meeting_type') == 'online' ? 'checked' : '' }}
                                    style="width: 1.25rem; height: 1.25rem; accent-color: #064e3b;">
                                <div>
                                    <span style="display: block; font-weight: 700; font-size: 0.875rem; color: #111827;">Online (Zoom)</span>
                                    <span style="display: block; font-size: 0.75rem; color: #6b7280;">Link akan dikirim via tracking</span>
                                </div>
                            </label>
                        </div>
                        @error('meeting_type')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 2rem 0;">

                    {{-- Topik --}}
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="purpose" class="form-label" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Topik yang Ingin Dibahas <span style="color: #dc2626;">*</span>
                        </label>
                        <textarea name="purpose" id="purpose" rows="4"
                            class="form-textarea @error('purpose') border-red-500 @enderror"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                            placeholder="Jelaskan secara singkat topik atau masalah yang ingin Anda konsultasikan..."
                            required>{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="form-error" style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                        <p class="form-help" style="font-size: 0.75rem; color: #9ca3af; text-align: right; margin-top: 0.25rem;">Maksimal 2000 karakter</p>
                    </div>

                    {{-- Info Alert --}}
                    <div class="alert alert-info" style="background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 1rem 1.25rem; color: #064e3b; margin-bottom: 2rem;">
                        <p style="font-weight: 700; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Informasi:</p>
                        <p style="font-size: 0.85rem; margin: 0; line-height: 1.5; color: #043e2f;">
                            Setelah booking, status pengajuan Anda akan <strong>Pending</strong> menunggu konfirmasi admin. Cek status secara berkala menggunakan kode tracking.
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem;">
                        <button type="submit" class="btn-green-submit" style="flex: 1;">
                            Booking Sekarang
                        </button>
                        <a href="{{ route('meeting.calendar') }}"
                            style="color: #6b7280; text-decoration: none; font-weight: 600; font-size: 0.875rem; padding: 0.875rem 1.25rem; transition: color 0.2s;"
                            onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection