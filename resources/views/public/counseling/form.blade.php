@extends('layouts.app')

@section('title', 'Form Konseling - Konseling FT UNESA')

@section('content')
    <style>
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #064e3b !important;
            outline: none;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.15) !important;
        }
        .btn-green-submit {
            background-color: #064e3b;
            color: #ffffff;
            border: none;
            padding: 0.875rem 1.75rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
            flex: 1;
            text-align: center;
        }
        .btn-green-submit:hover {
            background-color: #043e2f;
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.3);
        }
        .radio-option:hover {
            border-color: #064e3b !important;
        }
    </style>

    <div style="padding: 3rem 1rem 5rem 1rem; background-color: #f9fafb; min-height: calc(100vh - 160px);">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1rem;">
            
            {{-- Card Utama --}}
            <div style="background: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.04); padding: 2.5rem 2rem;">
                
                {{-- Header --}}
                <div style="margin-bottom: 2rem; border-bottom: 1px solid #f3f4f6; padding-bottom: 1.5rem;">
                    <h1 style="font-size: 1.875rem; font-weight: 800; color: #064e3b; margin: 0 0 0.5rem 0;">
                        {{ $type === 'anonymous' ? 'Konseling Anonim' : 'Form Konseling' }}
                    </h1>
                    <p style="color: #6b7280; font-size: 0.95rem; margin: 0; line-height: 1.5;">
                        {{ $type === 'anonymous' ? 'Anda tidak perlu mengisi data diri. Langsung sampaikan keluhan Anda.' : 'Lengkapi data diri Anda untuk memulai konseling.' }}
                    </p>
                </div>

                <form action="{{ route('counseling.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="identity_type" value="{{ $type }}">

                    @if($type === 'open')
                        <!-- Data Diri -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="name" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                Nama Lengkap <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-input @error('name') border-red-500 @enderror" placeholder="Masukkan nama lengkap"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                                required>
                            @error('name')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                Email (Untuk Notifikasi) <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-input @error('email') border-red-500 @enderror" placeholder="nama@email.com"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                                required>
                            @error('email')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Status Civitas -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="user_status" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                Status <span style="color: #dc2626;">*</span>
                            </label>
                            <select name="user_status" id="user_status" class="form-select @error('user_status') border-red-500 @enderror" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem; background-color: #ffffff;" required>
                                <option value="" disabled selected>Pilih Status...</option>
                                <option value="Dosen" {{ old('user_status') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="Karyawan" {{ old('user_status') == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                <option value="Mahasiswa" {{ old('user_status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            </select>
                            @error('user_status')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="employee_id" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                Nomor Induk (NIM/NIP/NIDN) <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id') }}"
                                class="form-input @error('employee_id') border-red-500 @enderror" placeholder="Contoh: 12345678"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                                required>
                            @error('employee_id')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input Nomor HP / WhatsApp --}}
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

                        <!-- Form Rumpun -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="rumpun" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
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
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Prodi -->
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="prodi" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                Program Studi (Prodi) <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}"
                                class="form-input @error('prodi') border-red-500 @enderror" placeholder="Contoh: Sistem Informasi"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                                required>
                            @error('prodi')
                                <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 2rem 0;">
                    @endif

                    <!-- Detail Masalah -->
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="topic" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Topik Konseling <span style="color: #dc2626;">*</span>
                        </label>
                        <select name="topic" id="topic" class="form-select @error('topic') border-red-500 @enderror"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem; background-color: #ffffff;" required>
                            <option value="" disabled selected>Pilih topik yang sesuai...</option>
                            <option value="Akademik" {{ old('topic') == 'Akademik' ? 'selected' : '' }}>Masalah Akademik / Kuliah</option>
                            <option value="Pekerjaan" {{ old('topic') == 'Pekerjaan' ? 'selected' : '' }}>Masalah Pekerjaan / Karir</option>
                            <option value="Keluarga" {{ old('topic') == 'Keluarga' ? 'selected' : '' }}>Masalah Keluarga / Pribadi</option>
                            <option value="Hubungan" {{ old('topic') == 'Hubungan' ? 'selected' : '' }}>Hubungan dengan Rekan/Teman</option>
                            <option value="Stress" {{ old('topic') == 'Stress' ? 'selected' : '' }}>Stress / Burnout</option>
                            <option value="Lainnya" {{ old('topic') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('topic')
                            <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.75rem;">
                            Sudah berapa lama masalah ini berlangsung? <span style="color: #dc2626;">*</span>
                        </label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.75rem;">
                            <label class="radio-option" style="border: 1px solid #d1d5db; padding: 0.75rem 1rem; border-radius: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151; transition: all 0.2s;">
                                <input type="radio" name="duration" value="< 1 minggu" {{ old('duration') == '< 1 minggu' ? 'checked' : '' }} style="accent-color: #064e3b;" required>
                                <span>Baru terjadi (&lt; 1 minggu)</span>
                            </label>
                            <label class="radio-option" style="border: 1px solid #d1d5db; padding: 0.75rem 1rem; border-radius: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151; transition: all 0.2s;">
                                <input type="radio" name="duration" value="1-4 minggu" {{ old('duration') == '1-4 minggu' ? 'checked' : '' }} style="accent-color: #064e3b;">
                                <span>1-4 minggu</span>
                            </label>
                            <label class="radio-option" style="border: 1px solid #d1d5db; padding: 0.75rem 1rem; border-radius: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151; transition: all 0.2s;">
                                <input type="radio" name="duration" value="1-3 bulan" {{ old('duration') == '1-3 bulan' ? 'checked' : '' }} style="accent-color: #064e3b;">
                                <span>1-3 bulan</span>
                            </label>
                            <label class="radio-option" style="border: 1px solid #d1d5db; padding: 0.75rem 1rem; border-radius: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151; transition: all 0.2s;">
                                <input type="radio" name="duration" value="> 3 bulan" {{ old('duration') == '> 3 bulan' ? 'checked' : '' }} style="accent-color: #064e3b;">
                                <span>Lebih dari 3 bulan</span>
                            </label>
                        </div>
                        @error('duration')
                            <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="issue_description" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Apa yang ingin Anda konsultasikan? <span style="color: #dc2626;">*</span>
                        </label>
                        <textarea name="issue_description" id="issue_description" rows="5"
                            class="form-textarea @error('issue_description') border-red-500 @enderror"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.75rem; font-size: 0.875rem;"
                            placeholder="Tuliskan keluhan atau hal yang ingin Anda konsultasikan..."
                            required>{{ old('issue_description') }}</textarea>
                        @error('issue_description')
                            <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                        @enderror
                        <p style="font-size: 0.75rem; color: #9ca3af; text-align: right; margin-top: 0.25rem;">Maksimal 2000 karakter</p>
                    </div>

                    {{-- Information Alert --}}
                    <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 1rem 1.25rem; color: #064e3b; margin-bottom: 2rem;">
                        <p style="font-weight: 700; font-size: 0.875rem; margin: 0 0 0.25rem 0;">Informasi:</p>
                        <p style="font-size: 0.85rem; margin: 0; line-height: 1.5; color: #043e2f;">
                            Setelah mengirim, Anda akan mendapatkan kode tracking unik untuk mengakses ruang chat konseling.
                        </p>
                    </div>

                    {{-- Form Actions --}}
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <button type="submit" class="btn-green-submit">
                            Mulai Konseling
                        </button>
                        <a href="{{ route('counseling.identity') }}"
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