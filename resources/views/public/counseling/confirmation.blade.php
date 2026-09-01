@extends('layouts.app')

@section('title', 'Konfirmasi Konseling - Konseling FT UNESA')

@section('content')
    <div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-[calc(100vh-160px)] flex items-center justify-center">
        <div class="w-full max-w-md mx-auto">
            
            {{-- Card Utama --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl p-6 sm:p-10 text-center">
                
                {{-- Success Icon --}}
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                {{-- Title & Subtitle --}}
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2">
                    Konseling Berhasil Dibuat
                </h1>
                <p class="text-gray-500 text-sm sm:text-base leading-relaxed mb-8">
                    Simpan kode tracking berikut untuk melanjutkan chat konseling Anda.
                </p>

                {{-- Kode Tracking Box --}}
                <div class="bg-emerald-50/60 border-2 border-dashed border-[#064e3b] rounded-2xl p-6 mb-6">
                    <p class="text-xs font-bold text-[#064e3b] uppercase tracking-wider mb-2">
                        Kode Tracking
                    </p>
                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <p id="trackingCodeText" class="text-2xl sm:text-3xl font-black text-[#064e3b] font-mono tracking-widest">
                            {{ $session->tracking_code }}
                        </p>
                        <button type="button" 
                            class="bg-[#064e3b] hover:bg-[#043e2f] text-white px-3.5 py-2 rounded-lg text-sm font-semibold inline-flex items-center gap-1.5 transition-colors cursor-pointer" 
                            onclick="copyTrackingCode('{{ $session->tracking_code }}', this)" 
                            title="Salin Kode">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 002-2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span id="copyBtnText">Salin</span>
                        </button>
                    </div>
                </div>

                {{-- Alert Warning --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-amber-800 text-left flex gap-3 items-start mb-8">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-xs sm:text-sm leading-relaxed text-amber-900">
                        <strong class="font-bold">Penting:</strong> Simpan kode ini dengan baik. Anda memerlukan kode ini untuk mengakses chat konseling Anda di masa mendatang.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col gap-3.5 items-center">
                    <a href="{{ route('counseling.chat', ['code' => $session->tracking_code]) }}" 
                        class="w-full bg-[#064e3b] hover:bg-[#043e2f] text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg transition-all text-center text-sm sm:text-base">
                        Lanjutkan ke Chat
                    </a>
                    <a href="{{ route('home') }}"
                        class="text-gray-500 hover:text-[#064e3b] font-semibold text-sm p-2 transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>

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