@extends('admin.layouts.app')

@section('title', 'Tambah Slot Jadwal')

@section('content')
    <!-- Back Link -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.schedules.index') }}" 
            class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-[#064e3b] transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Form Card Container -->
    <div class="max-w-2xl bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
        <h2 class="text-xl sm:text-2xl font-extrabold text-[#064e3b] tracking-tight mb-6">
            Tambah Slot Jadwal
        </h2>

        <form id="createScheduleForm" action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Konselor --}}
            <div>
                <label for="konselor_name" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Nama Konselor <span class="text-red-600">*</span>
                </label>
                <select name="konselor_name" id="konselor_name" required
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all cursor-pointer @error('konselor_name') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                    <option value="" disabled selected>Pilih Konselor</option>
                    @foreach($konselors as $konselor)
                        <option value="{{ $konselor->name }}" {{ old('konselor_name') == $konselor->name ? 'selected' : '' }}>
                            {{ $konselor->name }}
                        </option>
                    @endforeach
                </select>
                @error('konselor_name')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Rumpun --}}
            <div>
                <label for="rumpun" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Rumpun
                </label>
                <select name="rumpun" id="rumpun"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all cursor-pointer @error('rumpun') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                    <option value="" disabled selected>Pilih Rumpun (Opsional)</option>
                    @foreach(['PKK', 'Sipil', 'Elektro', 'Mesin', 'Informatika'] as $rmp)
                        <option value="{{ $rmp }}" {{ old('rumpun') == $rmp ? 'selected' : '' }}>{{ $rmp }}</option>
                    @endforeach
                </select>
                @error('rumpun')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="schedule_date" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Tanggal <span class="text-red-600">*</span>
                </label>
                <input type="date" name="schedule_date" id="schedule_date" required min="{{ date('Y-m-d') }}"
                    value="{{ old('schedule_date') }}"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all @error('schedule_date') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                @error('schedule_date')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Waktu Mulai & Selesai --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                        Waktu Mulai <span class="text-red-600">*</span>
                    </label>
                    <input type="time" name="start_time" id="start_time" required value="{{ old('start_time', '09:00') }}"
                        class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all @error('start_time') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                    @error('start_time')
                        <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                        Waktu Selesai <span class="text-red-600">*</span>
                    </label>
                    <input type="time" name="end_time" id="end_time" required value="{{ old('end_time', '10:00') }}"
                        class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all @error('end_time') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                    @error('end_time')
                        <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Maksimal Booking --}}
            <div>
                <label for="max_slots" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">
                    Maksimal Booking <span class="text-red-600">*</span>
                </label>
                <input type="number" name="max_slots" id="max_slots" required value="{{ old('max_slots', 1) }}" min="1" max="10"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-[#064e3b]/20 bg-white transition-all @error('max_slots') border-red-500 focus:border-red-500 @else border-slate-300 focus:border-[#064e3b] @enderror">
                @error('max_slots')
                    <p class="text-red-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-slate-400 text-xs mt-1.5 italic">Jumlah maksimal booking untuk slot ini (1-10)</p>
            </div>

            {{-- Submit & Cancel Buttons --}}
            <div class="flex items-center gap-4 pt-3">
                <button type="submit" id="btnSubmitSchedule"
                    class="flex-1 py-3 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md hover:shadow-lg cursor-pointer">
                    Simpan Slot
                </button>
                <a href="{{ route('admin.schedules.index') }}"
                    class="px-4 py-3 text-slate-500 hover:text-[#064e3b] text-xs sm:text-sm font-bold transition-colors">
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
                    submitBtn.classList.remove('bg-[#064e3b]', 'hover:bg-[#043e2f]', 'shadow-md', 'hover:shadow-lg');
                    submitBtn.classList.add('bg-slate-400', 'cursor-not-allowed');
                });
            }
        });
    </script>
@endsection