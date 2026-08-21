@extends('admin.layouts.app')

@section('title', 'Kelola Data Konselor')

@section('content')
    <div class="card">
        <div class="flex justify-between items-center mb-6" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <div>
                <h3 class="font-bold text-lg" style="font-weight: 700; font-size: 1.125rem; color: #111827; margin: 0;">Daftar Konselor</h3>
                <p class="text-muted text-sm" style="color: #6B7280; font-size: 0.875rem; margin: 0.25rem 0 0 0;">Kelola akun konselor Fakultas Teknik.</p>
            </div>
            <div>
                {{-- Tombol Tambah Konselor --}}
                <a href="{{ route('admin.counselors.create') }}" 
                   class="btn"
                   style="background-color: #064e3b !important; color: #ffffff !important; padding: 0.625rem 1.25rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2); border: none; transition: all 0.2s ease;"
                   onmouseover="this.style.backgroundColor='#043e2f'"
                   onmouseout="this.style.backgroundColor='#064e3b'">
                    + Tambah Konselor
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #E5E7EB;">
                        <th class="p-3 text-sm font-semibold text-gray-600" style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #4B5563;">No</th>
                        <th class="p-3 text-sm font-semibold text-gray-600" style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #4B5563;">Nama Konselor</th>
                        <th class="p-3 text-sm font-semibold text-gray-600" style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #4B5563;">Email</th>
                        <th class="p-3 text-sm font-semibold text-gray-600" style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #4B5563;">Tanggal Terdaftar</th>
                        <th class="p-3 text-sm font-semibold text-gray-600" style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #4B5563;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($counselors as $index => $counselor)
                        <tr style="border-bottom: 1px solid #F3F4F6;">
                            <td style="padding: 0.75rem; font-size: 0.875rem; color: #374151;">
                                {{ $counselors->firstItem() + $index }}
                            </td>
                            <td style="padding: 0.75rem; font-size: 0.875rem; font-weight: 600; color: #111827;">
                                {{ $counselor->name }}
                            </td>
                            <td style="padding: 0.75rem; font-size: 0.875rem; color: #4B5563;">
                                {{ $counselor->email }}
                            </td>
                            <td style="padding: 0.75rem; font-size: 0.875rem; color: #6B7280;">
                                {{ $counselor->created_at->format('d M Y') }}
                            </td>
                            <td style="padding: 0.75rem;">
                                <form action="{{ route('admin.counselors.destroy', $counselor->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus konselor ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:text-red-700"
                                        style="background: none; border: none; cursor: pointer; color: #DC2626;"
                                        title="Hapus Konselor">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-muted" style="padding: 1.5rem; text-align: center; color: #9CA3AF;">
                                Belum ada data konselor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4" style="margin-top: 1rem;">
            {{ $counselors->links() }}
        </div>
    </div>
@endsection