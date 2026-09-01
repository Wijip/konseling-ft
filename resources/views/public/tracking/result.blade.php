@extends('layouts.app')

@section('title', 'Detail Status Layanan - Konseling FT UNESA')

@section('content')
    <div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-[calc(100vh-160px)] flex items-center justify-center">
        <div class="w-full max-w-xl mx-auto">
            
            {{-- Header & Kode Tracking --}}
            <div class="text-center mb-8">
                <a href="{{ route('tracking.index') }}" 
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-[#064e3b] transition-colors mb-3">
                    ← Cek Kode Lain
                </a>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Status Layanan</h1>
                
                {{-- Box Kode Tracking + Tombol Copy --}}
                <div class="bg-emerald-50/70 border-2 border-dashed border-[#064e3b] rounded-2xl px-5 py-3.5 mt-4 inline-flex items-center justify-center gap-3 flex-wrap">
                    <span id="trackingCodeText" class="text-xl sm:text-2xl font-black text-[#064e3b] font-mono tracking-widest">
                        {{ $data->tracking_code }}
                    </span>
                    <button type="button" 
                        class="bg-[#064e3b] hover:bg-[#043e2f] text-white px-3 py-1.5 rounded-lg text-xs sm:text-sm font-semibold inline-flex items-center gap-1.5 transition-colors cursor-pointer" 
                        onclick="copyTrackingCode('{{ $data->tracking_code }}', this)" 
                        title="Salin Kode">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span id="copyBtnText">Salin</span>
                    </button>
                </div>
            </div>

            {{-- Card Utama --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 sm:p-10">

                {{-- Status Badge --}}
                <div class="text-center mb-8">
                    <span class="text-sm sm:text-base font-bold px-6 py-2 rounded-full inline-block
                        @if($data->status == 'pending') bg-amber-100 text-amber-700 
                        @elseif($data->status == 'approved' || $data->status == 'completed' || $data->status == 'in_progress') bg-emerald-100 text-[#064e3b] 
                        @elseif($data->status == 'rejected') bg-red-100 text-red-700 
                        @endif">
                        @if($type == 'counseling')
                            @if($data->status == 'pending') Pending
                            @elseif($data->status == 'in_progress') Dalam Proses
                            @elseif($data->status == 'completed') Selesai
                            @else {{ ucfirst(str_replace('_', ' ', $data->status)) }}
                            @endif
                        @else
                            {{ strtoupper(str_replace('_', ' ', $data->status)) }}
                        @endif
                    </span>
                    <p class="text-gray-500 text-xs sm:text-sm mt-3">
                        Update terakhir: {{ $data->updated_at->format('d M Y, H:i') }} WIB
                    </p>
                </div>

                {{-- Detail Pengajuan --}}
                <div class="border-y border-gray-100 py-6 mb-8">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4">Detail Pengajuan</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <div class="text-gray-500 text-xs sm:text-sm mb-1">Jenis Layanan</div>
                            <div class="font-bold text-gray-900 text-sm sm:text-base">
                                {{ $type == 'counseling' ? 'Konseling Online' : 'Pertemuan Langsung' }}
                            </div>
                        </div>

                        @if($type == 'counseling')
                            <div>
                                <div class="text-gray-500 text-xs sm:text-sm mb-1">Tipe Identitas</div>
                                <div class="font-bold text-gray-900 text-sm sm:text-base">
                                    {{ $data->identity_type == 'anonymous' ? 'Anonim' : 'Non-Anonim' }}
                                </div>
                            </div>
                        @else
                            <div>
                                <div class="text-gray-500 text-xs sm:text-sm mb-1">Jadwal</div>
                                <div class="font-bold text-gray-900 text-sm sm:text-base">
                                    {{ $data->schedule->schedule_date->format('d M Y') }}
                                    <br>
                                    <span class="text-[#064e3b]">
                                        {{ \Carbon\Carbon::parse($data->schedule->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($data->schedule->end_time)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if(isset($data->name) && $data->name)
                            <div>
                                <div class="text-gray-500 text-xs sm:text-sm mb-1">Nama Pemohon</div>
                                <div class="font-bold text-gray-900 text-sm sm:text-base">{{ $data->name }}</div>
                            </div>
                        @endif

                        @if($type == 'meeting' && $data->admin_notes)
                            <div class="col-span-1 sm:col-span-2 bg-gray-50 border border-gray-200 rounded-xl p-4 mt-2">
                                <div class="text-gray-700 text-xs sm:text-sm font-bold mb-1">Catatan Admin:</div>
                                <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">{{ $data->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Button / Instructions --}}
                @if($type == 'counseling')
                    <div class="text-center">
                        <a href="{{ route('counseling.chat', $data->tracking_code) }}" 
                            class="w-full bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-center text-sm sm:text-base block">
                            Buka Ruang Chat
                        </a>
                    </div>
                @else
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-[#064e3b]">
                        <p class="font-bold text-sm mb-1">Instruksi:</p>
                        <p class="text-xs sm:text-sm leading-relaxed text-[#043e2f]">
                            Apabila ada yang ingin ditanyakan atau terdapat perubahan jadwal, silakan menghubungi Contact Person HC berikut: 
                            <strong class="font-bold text-[#064e3b]">0812-3456-7789</strong>
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function copyTrackingCode(code, btnElement) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(code).then(() => showCopySuccess(btnElement));
            } else {
                let textArea = document.createElement("textarea");
                textArea.value = code;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showCopySuccess(btnElement);
                } catch (err) {
                    console.error('Gagal menyalin kode tracking', err);
                }
                document.body.removeChild(textArea);
            }
        }

        function showCopySuccess(btnElement) {
            const btnText = btnElement.querySelector('#copyBtnText');
            const originalText = btnText.innerText;
            btnText.innerText = 'Tersalin!';
            btnElement.classList.remove('bg-[#064e3b]', 'hover:bg-[#043e2f]');
            btnElement.classList.add('bg-emerald-700');
            setTimeout(() => {
                btnText.innerText = originalText;
                btnElement.classList.remove('bg-emerald-700');
                btnElement.classList.add('bg-[#064e3b]', 'hover:bg-[#043e2f]');
            }, 2000);
        }
    </script>
@endsection