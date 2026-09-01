@extends('admin.layouts.app')

@section('title', 'Kelola Jadwal Pertemuan')

@section('content')
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
        
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h3 class="font-extrabold text-lg sm:text-xl text-slate-900">Daftar Jadwal</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Atur ketersediaan waktu untuk konseling tatap muka.</p>
            </div>
            <div>
                <a href="{{ route('admin.schedules.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Jadwal</span>
                </a>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-4 whitespace-nowrap">Tanggal</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Jam</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Konselor</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Rumpun</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Slot Terisi</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-4 whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-900">
                                {{ $schedule->schedule_date->format('d M Y') }}
                                <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $schedule->schedule_date->translatedFormat('l') }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600 font-mono">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-700 font-medium">{{ $schedule->konselor_name ?? '-' }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-700 font-medium">{{ $schedule->rumpun ?? '-' }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold
                                    {{ $schedule->booked_slots >= $schedule->max_slots ? 'bg-red-100 text-red-700' : 'bg-sky-100 text-sky-700' }}">
                                    {{ $schedule->booked_slots }} / {{ $schedule->max_slots }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold cursor-pointer transition-transform active:scale-95 border-0
                                        {{ $schedule->is_available ? 'bg-emerald-100 text-[#064e3b] hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ $schedule->is_available ? 'Aktif' : 'Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus jadwal ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors cursor-pointer border-0"
                                        title="Hapus Jadwal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400 text-sm">
                                Belum ada jadwal dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $schedules->links() }}
        </div>
    </div>
@endsection