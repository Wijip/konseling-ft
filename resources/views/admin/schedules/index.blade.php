@extends('admin.layouts.app')

@section('title', 'Kelola Jadwal Pertemuan')

@section('content')
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-lg">Daftar Jadwal</h3>
                <p class="text-muted text-sm">Atur ketersediaan waktu untuk konseling tatap muka.</p>
            </div>
            <div>
                {{-- Tombol Tambah Jadwal --}}
                <a href="{{ route('admin.schedules.create') }}" 
                   class="btn"
                   style="background-color: #064e3b !important; color: #ffffff !important; padding: 0.625rem 1.25rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2); border: none; transition: all 0.2s ease;"
                   onmouseover="this.style.backgroundColor='#043e2f'"
                   onmouseout="this.style.backgroundColor='#064e3b'">
                    + Tambah Jadwal
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr style="border-bottom: 2px solid #E5E7EB;">
                        <th class="p-3 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Jam</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Konselor</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Rumpun</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Slot Terisi</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr style="border-bottom: 1px solid #F3F4F6;">
                            <td class="p-3 text-sm text-gray-700 font-medium">
                                {{ $schedule->schedule_date->format('d M Y') }}
                                <br>
                                <span class="text-xs text-muted">{{ $schedule->schedule_date->translatedFormat('l') }}</span>
                            </td>
                            <td class="p-3 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </td>
                            <td class="p-3 text-sm text-gray-600">{{ $schedule->konselor_name ?? '-' }}</td>
                            <td class="p-3 text-sm text-gray-600 font-medium">{{ $schedule->rumpun ?? '-' }}</td>
                            <td class="p-3 text-sm">
                                <span
                                    class="badge {{ $schedule->booked_slots >= $schedule->max_slots ? 'badge-danger' : 'badge-info' }}">
                                    {{ $schedule->booked_slots }} / {{ $schedule->max_slots }}
                                </span>
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="badge {{ $schedule->is_available ? 'badge-success' : 'badge-secondary' }} cursor-pointer"
                                        style="border: none;">
                                        {{ $schedule->is_available ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="p-3 flex gap-2">
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:text-red-700"
                                        style="background: none; border: none; cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-muted">Belum ada jadwal dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </div>
@endsection