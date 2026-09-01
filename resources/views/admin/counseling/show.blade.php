@extends('admin.layouts.app')

@section('title', 'Detail Konseling')

@section('content')
    <!-- Back Link -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('admin.counseling.index') }}"
            class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-500 hover:text-[#064e3b] transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Chat Area (Left Column - Spans 2 Cols on Large Screens) -->
        <div class="lg:col-span-2 bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm flex flex-col h-[calc(100vh-200px)] min-h-[500px]">
            
            <!-- Header Chat -->
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Chat Konseling</h3>
                    <p class="text-xs sm:text-sm font-mono font-bold text-[#064e3b] mt-0.5">{{ $session->tracking_code }}</p>
                </div>
                
                @php
                    $badgeClass = 'bg-amber-100 text-amber-700';
                    $statusLabel = 'Pending';

                    if ($session->status == 'completed') {
                        $badgeClass = 'bg-emerald-100 text-[#064e3b]';
                        $statusLabel = 'Selesai';
                    } elseif ($session->status == 'in_progress') {
                        $badgeClass = 'bg-blue-100 text-blue-700';
                        $statusLabel = 'Dalam Proses';
                    } elseif ($session->status == 'rejected') {
                        $badgeClass = 'bg-red-100 text-red-700';
                        $statusLabel = 'Ditolak';
                    }
                @endphp
                <span class="px-3 py-1 rounded-full text-xs sm:text-sm font-bold {{ $badgeClass }}">
                    {{ $statusLabel }}
                </span>
            </div>

            <!-- Messages Stream Area -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 bg-slate-50/50">
                
                <!-- Original Issue Message (Left) -->
                <div class="flex flex-col items-start">
                    <div class="bg-white border border-slate-100 p-3.5 sm:p-4 rounded-2xl rounded-tl-xs max-w-[85%] sm:max-w-[75%] shadow-xs">
                        <p class="text-xs sm:text-sm text-slate-800 leading-relaxed">{{ $session->issue_description }}</p>
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">{{ $session->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <!-- Chat History Loop -->
                @foreach($session->messages as $msg)
                    @if($msg->sender_type == 'user')
                        <!-- User Message (Left) -->
                        <div class="flex flex-col items-start">
                            <div class="bg-white border border-slate-100 p-3.5 sm:p-4 rounded-2xl rounded-tl-xs max-w-[85%] sm:max-w-[75%] shadow-xs">
                                <p class="text-xs sm:text-sm text-slate-800 leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[10px] text-slate-400 mt-2 font-medium">{{ $msg->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <!-- Admin Message (Right) -->
                        <div class="flex flex-col items-end">
                            <div class="bg-[#064e3b] text-white p-3.5 sm:p-4 rounded-2xl rounded-tr-xs max-w-[85%] sm:max-w-[75%] shadow-md">
                                <p class="text-xs sm:text-sm leading-relaxed">{{ $msg->message }}</p>
                                <p class="text-[10px] text-white/75 mt-2 text-right font-medium">{{ $msg->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Reply Input Bar -->
            <div class="p-4 sm:p-5 border-t border-slate-100 bg-white rounded-b-2xl sm:rounded-b-3xl">
                @if(!in_array($session->status, ['completed', 'rejected']))
                    <form id="replyForm" action="{{ route('admin.counseling.reply', $session->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center gap-2.5">
                            <input type="text" name="message" id="replyMessage" placeholder="Tulis balasan..." required autocomplete="off"
                                class="flex-1 px-4 py-2.5 text-xs sm:text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 transition-all placeholder-slate-400">
                            <button type="submit" id="replyBtn" 
                                class="px-5 py-2.5 bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold text-xs sm:text-sm rounded-xl transition-all shadow-md hover:shadow-lg whitespace-nowrap cursor-pointer">
                                Kirim
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-slate-50 p-3.5 rounded-xl text-center border border-slate-200">
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">
                            {{ $session->status == 'completed' ? 'Sesi konseling ini telah selesai.' : 'Sesi konseling ini telah ditolak.' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Actions & Details (Right Column) -->
        <div class="space-y-6">
            
            <!-- Client Information Card -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-6">
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 pb-3 mb-4 border-b border-slate-100">Informasi Klien</h3>
                <div class="text-center">
                    <div class="w-14 h-14 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-3 shadow-xs">
                        <svg class="w-7 h-7 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    
                    <div class="mb-4">
                        @if($session->identity_type == 'anonymous')
                            <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold">Klien Anonim</span>
                        @else
                            <p class="font-extrabold text-base text-slate-900 mb-1">{{ $session->name }}</p>
                            @if($session->user_status || $session->status_user)
                                <span class="inline-block px-2.5 py-0.5 bg-sky-50 text-sky-700 rounded-md text-xs font-bold">
                                    Civitas: {{ $session->user_status ?? $session->status_user }}
                                </span>
                            @endif
                        @endif
                    </div>

                    @if($session->identity_type != 'anonymous')
                        <div class="text-left bg-slate-50 p-3.5 rounded-xl border border-slate-100 mb-4 text-xs space-y-2.5">
                            <div>
                                <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider">NIP / NIM</span>
                                <span class="font-bold text-slate-800">{{ $session->employee_id ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider">Asal Instansi / Fakultas</span>
                                <span class="font-bold text-slate-800">{{ $session->faculty_origin ?? 'Fakultas Teknik' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider">Rumpun / Program Studi</span>
                                <span class="font-bold text-slate-800">{{ $session->division ?? '-' }} / {{ $session->jabatan ?? '-' }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- WhatsApp Direct Button --}}
                    @if($session->phone_number)
                        @php
                            $formattedPhone = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $session->phone_number));
                        @endphp
                        <div class="mb-4">
                            <a href="https://wa.me/{{ $formattedPhone }}" target="_blank"
                                class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-[#25D366] hover:bg-[#20ba5a] text-white rounded-xl text-xs sm:text-sm font-bold shadow-sm transition-all">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                </svg>
                                <span>Hubungi via WhatsApp</span>
                            </a>
                        </div>
                    @endif

                    {{-- Additional Notes --}}
                    @if($session->additional_notes)
                        <div class="text-left bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Keterangan Tambahan:</p>
                            <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">{{ $session->additional_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Update Status Card -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-6">
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 pb-3 mb-4 border-b border-slate-100">Ubah Status</h3>
                <form action="{{ route('admin.counseling.update', $session->id) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <select name="status"
                        class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-300 rounded-xl focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 bg-white cursor-pointer transition-all">
                        <option value="pending" {{ $session->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ $session->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="completed" {{ $session->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ $session->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit"
                        class="w-full py-3 bg-[#064e3b] hover:bg-[#043e2f] text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md hover:shadow-lg cursor-pointer">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Delete Session Card -->
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-6">
                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 pb-3 mb-4 border-b border-slate-100">Hapus Sesi</h3>
                <form action="{{ route('admin.counseling.destroy', $session->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi konseling ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs sm:text-sm font-bold transition-colors cursor-pointer shadow-sm">
                        Hapus Sesi
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Auto-scroll & Form Handling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto scroll to bottom of chat container
            const chatMessages = document.getElementById('chatMessages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Prevent double form submission
            const replyForm = document.getElementById('replyForm');
            if (replyForm) {
                let isSubmitting = false;
                replyForm.addEventListener('submit', function (e) {
                    if (isSubmitting) {
                        e.preventDefault();
                        return false;
                    }
                    isSubmitting = true;
                    const btn = document.getElementById('replyBtn');
                    if (btn) {
                        btn.disabled = true;
                        btn.textContent = 'Mengirim...';
                        btn.classList.remove('bg-[#064e3b]', 'hover:bg-[#043e2f]');
                        btn.classList.add('bg-slate-400', 'cursor-not-allowed');
                    }
                });
            }
        });
    </script>
@endsection