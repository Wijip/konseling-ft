@extends('admin.layouts.app')

@section('title', 'Tambah Slot Jadwal')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.schedules.index') }}" style="color: #6B7280; font-size: 0.875rem; text-decoration: none;" onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6B7280'">←
            Kembali ke Daftar</a>
    </div>

    <div
        style="max-width: 650px; background: white; border-radius: 12px; border: 1px solid #E5E7EB; padding: 2rem 2.25rem; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);">
        <h2
            style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1.375rem; color: #064e3b; margin: 0 0 1.75rem 0;">
            Tambah Slot Jadwal</h2>

        <form id="createScheduleForm" action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf

            {{-- Nama Konselor --}}
            <div style="margin-bottom: 1.5rem;">
                <label for="konselor_name"
                    style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Nama Konselor <span style="color: #dc2626;">*</span>
                </label>
                <select name="konselor_name" id="konselor_name" required
                    style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 1rem; font-family: 'Inter', sans-serif; color: #111827; background-color: #fff; appearance: auto; box-sizing: border-box; @error('konselor_name') border-color: #dc2626; @enderror">
                    <option value="" disabled selected>Pilih Konselor</option>
                    @foreach($konselors as $konselor)
                        <option value="{{ $konselor->name }}" {{ old('konselor_name') == $konselor->name ? 'selected' : '' }}>
                            {{ $konselor->name }}</option>
                    @endforeach
                </select>
                @error('konselor_name')
                    <p style="color: #dc2626; font-size: 0.75rem; margin: 0.375rem 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Rumpun --}}
            <div style="margin-bottom: 1.5rem;">
                <label for="rumpun"
                    style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Rumpun
                </label>
                <select name="rumpun" id="rumpun"
                    style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 1rem; font-family: 'Inter', sans-serif; color: #111827; background-color: #fff; appearance: auto; box-sizing: border-box; @error('rumpun') border-color: #dc2626; @enderror">
                    <option value="" disabled selected>Pilih Rumpun (Opsional)</option>
                    @foreach(['PKK', 'Sipil', 'Elektro', 'Mesin', 'Informatika'] as $rmp)
                        <option value="{{ $rmp }}" {{ old('rumpun') == $rmp ? 'selected' : '' }}>{{ $rmp }}</option>
                    @endforeach
                </select>
                @error('rumpun')
                    <p style="color: #dc2626; font-size: 0.75rem; margin: 0.375rem 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div style="margin-bottom: 1.5rem;">
                <label for="schedule_date"
                    style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Tanggal <span style="color: #dc2626;">*</span>
                </label>
                <input type="date" name="schedule_date" id="schedule_date" required min="{{ date('Y-m-d') }}"
                    value="{{ old('schedule_date') }}"
                    style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 1rem; font-family: 'Inter', sans-serif; color: #111827; box-sizing: border-box;">
                @error('schedule_date')
                    <p style="color: #dc2626; font-size: 0.75rem; margin: 0.375rem 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Waktu Mulai & Selesai --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label for="start_time"
                        style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        Waktu Mulai <span style="color: #dc2626;">*</span>
                    </label>
                    <input type="time" name="start_time" id="start_time" required value="{{ old('start_time', '09:00') }}"
                        style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 1rem; font-family: 'Inter', sans-serif; color: #111827; box-sizing: border-box;">
                    @error('start_time')
                        <p style="color: #dc2626; font-size: 0.75rem; margin: 0.375rem 0 0;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_time"
                        style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        Waktu Selesai <span style="color: #dc2626;">*</span>
                    </label>
                    <input type="time" name="end_time" id="end_time" required value="{{ old('end_time', '10:00') }}"
                        style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 1rem; font-family: 'Inter', sans-serif; color: #111827; box-sizing: border-box;">
                    @error('end_time')
                        <p style="color: #dc2626; font-size: 0.75rem; margin: 0.375rem 0 0;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Maksimal Booking --}}
            <div style="margin-bottom: 2rem;">
                <label for="max_slots"
                    style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                    Maksimal Booking <span style="color: #dc2626;">*</span>
                </label>
                <input type="number" name="max_slots" id="max_slots" required value="{{ old('max_slots', 1) }}" min="1"
                    max="10"
                    style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 1rem; font-family: 'Inter', sans-serif; color: #111827; box-sizing: border-box;">
                @error('max_slots')
                    <p style="color: #dc2626; font-size: 0.75rem; margin: 0.375rem 0 0;">{{ $message }}</p>
                @enderror
                <p style="color: #9ca3af; font-size: 0.8rem; margin: 0.5rem 0 0; font-style: italic;">Jumlah maksimal
                    booking untuk slot ini (1-10)</p>
            </div>

            {{-- Submit --}}
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <button type="submit" id="btnSubmitSchedule"
                    style="flex: 1; background-color: #064e3b; color: white; padding: 0.875rem 1.5rem; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 1rem; font-family: 'Inter', sans-serif; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);"
                    onmouseover="if(!this.disabled) this.style.backgroundColor='#043e2f'" onmouseout="if(!this.disabled) this.style.backgroundColor='#064e3b'">
                    Simpan Slot
                </button>
                <a href="{{ route('admin.schedules.index') }}"
                    style="color: #6b7280; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: color 0.2s;"
                    onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Script Mencegah Submit Ganda --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('createScheduleForm');
            const submitBtn = document.getElementById('btnSubmitSchedule');

            if (form && submitBtn) {
                let isSubmitting = false;

                form.addEventListener('submit', function (e) {
                    if (isSubmitting) {
                        e.preventDefault();
                        return false;
                    }

                    isSubmitting = true;
                    submitBtn.disabled = true;
                    submitBtn.innerText = 'Lagi Menyimpan...';
                    submitBtn.style.backgroundColor = '#9ca3af';
                    submitBtn.style.cursor = 'not-allowed';
                    submitBtn.style.boxShadow = 'none';
                });
            }
        });
    </script>
@endsection