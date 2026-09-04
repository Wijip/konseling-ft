@extends('admin.layouts.app')

@section('title', 'Kelola Data Konselor')

@section('content')
    <div x-data="{ showDeleteModal: false, deleteUrl: '', counselorName: '' }" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-7">
        
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
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.counselors.edit', $counselor->id) }}" 
                                       class="p-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors inline-block"
                                       title="Edit Konselor">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    <button type="button" 
                                            @click="showDeleteModal = true; deleteUrl = '{{ route('admin.counselors.destroy', $counselor->id) }}'; counselorName = '{{ addslashes($counselor->name) }}'"
                                            class="p-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors cursor-pointer border-0"
                                            title="Hapus Konselor">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </div>
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

        <!-- Modal Konfirmasi Hapus Custom (Referensi Gambar 1) -->
        <div x-show="showDeleteModal" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div @click.away="showDeleteModal = false" 
                 class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-xl border border-slate-100 transform transition-all"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Icon Warning Exclamation -->
                <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-red-50 border-8 border-red-50/50 text-red-500 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"></circle>
                        <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                    </svg>
                </div>

                <!-- Modal Title & Subtitle -->
                <h3 class="text-lg font-bold text-slate-900 mb-1">Hapus Konselor</h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-6 leading-relaxed">
                    Apakah Anda yakin ingin menghapus konselor <span class="font-bold text-slate-700" x-text="counselorName"></span>? Tindakan ini tidak dapat dibatalkan.
                </p>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" 
                            @click="showDeleteModal = false" 
                            class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs sm:text-sm transition-colors cursor-pointer">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full py-2.5 px-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl text-xs sm:text-sm transition-colors cursor-pointer shadow-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection