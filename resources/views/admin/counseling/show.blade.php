@extends('admin.layouts.app')

@section('title', 'Detail Konseling')

@section('content')
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.counseling.index') }}"
            style="color: #6b7280; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; transition: color 0.2s;"
            onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
            ← Kembali ke Daftar
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem;">
        <!-- Chat Area (Left) -->
        <div
            style="background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; flex-direction: column; height: calc(100vh - 200px);">
            <!-- Header -->
            <div style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0 0 0.25rem 0; color: #111827;">Chat
                            Konseling</h3>
                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $session->tracking_code }}</p>
                    </div>
                    @php
                        $badgeBg = '#fef3c7';
                        $badgeColor = '#d97706';
                        $statusLabel = 'Pending';

                        if ($session->status == 'completed') {
                            $badgeBg = '#dcfce7';
                            $badgeColor = '#16a34a';
                            $statusLabel = 'Selesai';
                        } elseif ($session->status == 'in_progress') {
                            $badgeBg = '#dbeafe';
                            $badgeColor = '#1e40af';
                            $statusLabel = 'Dalam Proses';
                        } elseif ($session->status == 'rejected') {
                            $badgeBg = '#fee2e2';
                            $badgeColor = '#991b1b';
                            $statusLabel = 'Ditolak';
                        }
                    @endphp
                    <span
                        style="display: inline-block; padding: 0.375rem 1rem; background: {{ $badgeBg }}; color: {{ $badgeColor }}; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            <!-- Messages -->
            <div id="chatMessages"
                style="flex: 1; overflow-y: auto; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; background: #f9fafb;">
                <!-- Original Issue -->
                <div style="display: flex; flex-direction: column; align-items: flex-start;">
                    <div
                        style="background: #f3f4f6; padding: 0.875rem 1rem; border-radius: 1rem; border-top-left-radius: 0.25rem; max-width: 70%; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <p style="margin: 0; font-size: 0.9rem; color: #1f2937; line-height: 1.5;">
                            {{ $session->issue_description }}</p>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.75rem; color: #9ca3af;">
                            {{ $session->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @foreach($session->messages as $msg)
                    @if($msg->sender_type == 'user')
                        <!-- User Message (Left) -->
                        <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <div
                                style="background: #f3f4f6; padding: 0.875rem 1rem; border-radius: 1rem; border-top-left-radius: 0.25rem; max-width: 70%; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <p style="margin: 0; font-size: 0.9rem; color: #1f2937; line-height: 1.5;">{{ $msg->message }}</p>
                                <p style="margin: 0.5rem 0 0 0; font-size: 0.75rem; color: #9ca3af;">
                                    {{ $msg->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <!-- Admin Message (Right) -->
                        <div style="display: flex; flex-direction: column; align-items: flex-end;">
                            <div
                                style="background: #064e3b; color: white; padding: 0.875rem 1rem; border-radius: 1rem; border-top-right-radius: 0.25rem; max-width: 70%; box-shadow: 0 2px 6px rgba(6, 78, 59, 0.25);">
                                <p style="margin: 0; font-size: 0.9rem; line-height: 1.5;">{{ $msg->message }}</p>
                                <p style="margin: 0.5rem 0 0 0; font-size: 0.75rem; opacity: 0.85;">
                                    {{ $msg->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Reply Input -->
            <div style="padding: 1.25rem; border-top: 1px solid #e5e7eb; background: white;">
                @if(!in_array($session->status, ['completed', 'rejected']))
                <form id="replyForm" action="{{ route('admin.counseling.reply', $session->id) }}" method="POST">
                    @csrf
                    <div style="display: flex; gap: 0.75rem;">
                        <input type="text" name="message" id="replyMessage" placeholder="Tulis balasan..." required autocomplete="off"
                            style="flex: 1; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; outline: none; transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='#064e3b'" onblur="this.style.borderColor='#d1d5db'">
                        <button type="submit" id="replyBtn" class="btn-primary"
                            style="padding: 0.75rem 1.5rem; background: #064e3b; color: white; border: none; border-radius: 0.5rem; font-weight: 700; cursor: pointer; transition: background 0.2s; white-space: nowrap; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);"
                            onmouseover="if(!this.disabled) this.style.background='#043e2f'" onmouseout="if(!this.disabled) this.style.background='#064e3b'">
                            Kirim
                        </button>
                    </div>
                </form>
                @else
                <div style="background: #f3f4f6; padding: 1rem; border-radius: 0.5rem; text-align: center; border: 1px solid #e5e7eb;">
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">
                        {{ $session->status == 'completed' ? 'Sesi konseling ini telah selesai.' : 'Sesi konseling ini telah ditolak.' }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar (Right) -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Client Info -->
            <div style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 1.25rem 0; color: #111827;">Informasi Klien</h3>
                <div style="text-align: center; padding: 0.5rem 0;">
                    <div
                        style="width: 4rem; height: 4rem; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem auto;">
                        <svg style="width: 2rem; height: 2rem; color: #064e3b;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div style="margin-bottom: 0.75rem;">
                        @if($session->identity_type == 'anonymous')
                            <span style="display:inline-block; padding: 0.25rem 0.75rem; background: #f3f4f6; color: #4b5563; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Klien Anonim</span>
                        @else
                            <p style="margin: 0 0 0.25rem 0; font-weight: 700; font-size: 1rem; color: #111827;">{{ $session->name }}</p>
                            @if($session->user_status || $session->status_user)
                                <span style="display:inline-block; padding: 0.2rem 0.6rem; background: #e0f2fe; color: #0369a1; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; margin-bottom: 0.5rem;">
                                    Civitas: {{ $session->user_status ?? $session->status_user }}
                                </span>
                            @endif
                        @endif
                    </div>

                    @if($session->identity_type != 'anonymous')
                        <div style="text-align: left; background: #f9fafb; padding: 0.875rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; margin-bottom: 1rem; font-size: 0.825rem; display: flex; flex-direction: column; gap: 0.375rem;">
                            <div>
                                <span style="color: #6b7280; display: block; font-size: 0.7rem; text-transform: uppercase; font-weight: 600;">NIP / NIM</span>
                                <span style="font-weight: 600; color: #1f2937;">{{ $session->employee_id ?? '-' }}</span>
                            </div>
                            <div>
                                <span style="color: #6b7280; display: block; font-size: 0.7rem; text-transform: uppercase; font-weight: 600;">Asal Instansi / Fakultas</span>
                                <span style="font-weight: 600; color: #1f2937;">{{ $session->faculty_origin ?? 'Fakultas Teknik' }}</span>
                            </div>
                            <div>
                                <span style="color: #6b7280; display: block; font-size: 0.7rem; text-transform: uppercase; font-weight: 600;">Rumpun / Program Studi</span>
                                <span style="font-weight: 600; color: #1f2937;">{{ $session->division ?? '-' }} / {{ $session->jabatan ?? '-' }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- Tombol Direct WhatsApp --}}
                    @if($session->phone_number)
                        @php
                            $formattedPhone = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $session->phone_number));
                        @endphp
                        <div style="margin-bottom: 1rem;">
                            <a href="https://wa.me/{{ $formattedPhone }}" target="_blank"
                               style="display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.625rem 1rem; background-color: #25D366; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 600; font-size: 0.875rem; box-shadow: 0 2px 4px rgba(37, 211, 102, 0.2); transition: background-color 0.2s;"
                               onmouseover="this.style.backgroundColor='#20ba5a'" onmouseout="this.style.backgroundColor='#25D366'">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                </svg>
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    @endif

                    {{-- Keterangan Tambahan --}}
                    @if($session->additional_notes)
                        <div style="text-align: left; background: #f9fafb; padding: 0.875rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 0.25rem 0; font-size: 0.75rem; font-weight: 700; color: #4b5563;">Keterangan Tambahan:</p>
                            <p style="margin: 0; font-size: 0.825rem; color: #1f2937; white-space: pre-line; line-height: 1.4;">{{ $session->additional_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Update Status -->
            <div style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 1rem 0; color: #111827;">Ubah Status</h3>
                <form action="{{ route('admin.counseling.update', $session->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; margin-bottom: 0.75rem; background: white; cursor: pointer;">
                        <option value="pending" {{ $session->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ $session->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="completed" {{ $session->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ $session->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit"
                        style="width: 100%; padding: 0.875rem; background: #064e3b; color: white; border: none; border-radius: 0.5rem; font-weight: 700; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);"
                        onmouseover="this.style.background='#043e2f'" onmouseout="this.style.background='#064e3b'">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Delete Session -->
            <div style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="font-size: 1rem; font-weight: 700; margin: 0 0 1rem 0; color: #111827;">Hapus Sesi</h3>
                <form action="{{ route('admin.counseling.destroy', $session->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi konseling ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="width: 100%; padding: 0.875rem; background: #dc2626; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: background 0.2s;"
                        onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                        Hapus Sesi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto scroll to bottom of chat
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
                        btn.style.background = '#9ca3af';
                        btn.style.cursor = 'not-allowed';
                    }
                });
            }
        });
    </script>
@endsection