@extends('layouts.app')

@section('title', 'Detail Status Layanan - Konseling FT UNESA')

@section('content')
    <style>
        .btn-green-action {
            background-color: #064e3b;
            color: #ffffff;
            display: inline-block;
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);
        }
        .btn-green-action:hover {
            background-color: #043e2f;
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.25);
        }
        .btn-copy-code {
            background-color: #064e3b;
            color: #ffffff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.4rem 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: background-color 0.2s ease;
        }
        .btn-copy-code:hover {
            background-color: #043e2f;
        }
    </style>

    <div style="padding: 3rem 1rem; background-color: #f9fafb; min-height: calc(100vh - 160px);">
        <div class="container" style="max-width: 700px; margin: 0 auto; padding: 0 1rem;">
            
            {{-- Header & Kode Tracking --}}
            <div style="text-align: center; margin-bottom: 2rem;">
                <a href="{{ route('tracking.index') }}" 
                   style="color: #6b7280; text-decoration: none; font-size: 0.875rem; font-weight: 600; display: inline-block; margin-bottom: 1rem; transition: color 0.2s;"
                   onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                    ← Cek Kode Lain
                </a>
                <h1 style="font-size: 1.875rem; font-weight: 800; color: #111827; margin: 0;">Status Layanan</h1>
                
                {{-- Box Kode Tracking + Tombol Copy --}}
                <div style="background: #f0fdf4; display: inline-flex; align-items: center; gap: 0.75rem; padding: 0.5rem 1.25rem; border-radius: 0.75rem; border: 1.5px dashed #064e3b; margin-top: 1rem; flex-wrap: wrap; justify-content: center;">
                    <span id="trackingCodeText" style="font-weight: 800; font-size: 1.5rem; letter-spacing: 2px; color: #064e3b; font-family: 'Courier New', monospace;">
                        {{ $data->tracking_code }}
                    </span>
                    <button type="button" class="btn-copy-code" onclick="copyTrackingCode('{{ $data->tracking_code }}', this)" title="Salin Kode">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span id="copyBtnText">Salin</span>
                    </button>
                </div>
            </div>

            {{-- Card Utama --}}
            <div class="card" style="background: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 2.5rem 2rem;">

                {{-- Status Badge --}}
                <div style="text-align: center; margin-bottom: 2rem;">
                    <span class="badge" style="font-size: 1rem; font-weight: 700; padding: 0.6rem 1.5rem; border-radius: 9999px; display: inline-block;
                        @if($data->status == 'pending') background: #FEF3C7; color: #D97706; 
                        @elseif($data->status == 'approved' || $data->status == 'completed' || $data->status == 'in_progress') background: #d1fae5; color: #064e3b; 
                        @elseif($data->status == 'rejected') background: #FEE2E2; color: #DC2626; 
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
                    <p style="color: #6b7280; font-size: 0.85rem; margin-top: 0.75rem;">
                        Update terakhir: {{ $data->updated_at->format('d M Y, H:i') }} WIB
                    </p>
                </div>

                {{-- Detail Pengajuan --}}
                <div style="border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; padding: 1.5rem 0; margin-bottom: 2rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin-bottom: 1.25rem;">Detail Pengajuan</h3>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem;">
                        <div>
                            <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Jenis Layanan</div>
                            <div style="font-weight: 700; color: #111827; font-size: 0.95rem;">
                                {{ $type == 'counseling' ? 'Konseling Online' : 'Pertemuan Langsung' }}
                            </div>
                        </div>

                        @if($type == 'counseling')
                            <div>
                                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Tipe Identitas</div>
                                <div style="font-weight: 700; color: #111827; font-size: 0.95rem;">
                                    {{ $data->identity_type == 'anonymous' ? 'Anonim' : 'Non-Anonim' }}
                                </div>
                            </div>
                        @else
                            <div>
                                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Jadwal</div>
                                <div style="font-weight: 700; color: #111827; font-size: 0.95rem;">
                                    {{ $data->schedule->schedule_date->format('d M Y') }}
                                    <br>
                                    <span style="color: #064e3b;">
                                        {{ \Carbon\Carbon::parse($data->schedule->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($data->schedule->end_time)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if(isset($data->name) && $data->name)
                            <div>
                                <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Nama Pemohon</div>
                                <div style="font-weight: 700; color: #111827; font-size: 0.95rem;">{{ $data->name }}</div>
                            </div>
                        @endif

                        @if($type == 'meeting' && $data->admin_notes)
                            <div style="grid-column: span 2; background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1rem; margin-top: 0.5rem;">
                                <div style="color: #374151; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.25rem;">Catatan Admin:</div>
                                <p style="color: #4b5563; margin: 0; font-size: 0.875rem;">{{ $data->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Button / Instructions --}}
                @if($type == 'counseling')
                    <div style="text-align: center;">
                        <a href="{{ route('counseling.chat', $data->tracking_code) }}" class="btn-green-action">
                            Buka Ruang Chat
                        </a>
                    </div>
                @else
                    <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 1.25rem; color: #064e3b;">
                        <div style="font-weight: 700; font-size: 0.95rem; margin-bottom: 0.35rem;">Instruksi:</div>
                        <p style="font-size: 0.875rem; margin: 0; line-height: 1.5; color: #043e2f;">
                            Apabila ada yang ingin ditanyakan atau terdapat perubahan jadwal, silakan menghubungi Contact Person HC berikut: 
                            <strong style="color: #064e3b;">0812-3456-7789</strong>
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
            btnElement.style.backgroundColor = '#047857';
            setTimeout(() => {
                btnText.innerText = originalText;
                btnElement.style.backgroundColor = '#064e3b';
            }, 2000);
        }
    </script>
@endsection