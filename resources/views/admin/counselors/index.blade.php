@extends('admin.layouts.app')

@section('title', 'Kelola Data Konselor')

@section('content')
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
        
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-100">
            <div>
                <h3 class="font-extrabold text-lg sm:text-xl text-slate-900">Daftar Konselor</h3>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Kelola akun konselor Fakultas Teknik.</p>
            </div>
            <div>
                <a href="{{ route('admin.counselors.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Konselor</span>
                </a>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-4 whitespace-nowrap text-center w-12">No</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Nama Konselor</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Email</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Tanggal Terdaftar</th>
                        <th class="py-3.5 px-4 whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($counselors as $index => $counselor)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 whitespace-nowrap text-center text-slate-400 font-medium">
                                {{ $counselors->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-bold text-slate-900">
                                {{ $counselor->name }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-600 font-mono">
                                {{ $counselor->email }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-slate-500">
                                {{ $counselor->created_at->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                <form action="{{ route('admin.counselors.destroy', $counselor->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus konselor ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors cursor-pointer border-0"
                                        title="Hapus Konselor">
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
                            <td colspan="5" class="text-center py-12 text-slate-400 text-sm">
                                Belum ada data konselor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $counselors->links() }}
        </div>
    </div>
@endsection