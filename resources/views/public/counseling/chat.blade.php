@extends('layouts.app')

@section('title', 'Chat Konseling - Konseling FT UNESA')

@section('content')
    <style>
        /* ===== Chat Mobile Responsive ===== */
        .chat-page-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .chat-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            border: 1px solid #f3f4f6;
        }

        .chat-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .chat-header h1 {
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            color: #064e3b;
        }

        .chat-header-meta {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .chat-tracking-code {
            font-family: monospace;
            font-weight: 700;
            color: #064e3b;
        }

        .chat-status-badge {
            font-weight: 700;
            font-size: 0.75rem;
            padding: 0.2rem 0.75rem;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .chat-exit-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: color 0.2s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .chat-exit-link:hover {
            color: #064e3b;
        }

        /* Messages area */
        #chat-messages {
            background: #f9fafb;
            padding: 1.5rem;
            height: 500px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            scroll-behavior: smooth;
        }

        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 20px;
        }

        #chat-messages::-webkit-scrollbar-thumb:hover {
            background-color: #9ca3af;
        }

        /* Chat bubbles */
        .chat-bubble-user {
            max-width: 75%;
            background: #064e3b;
            color: white;
            padding: 1rem 1.25rem;
            border-radius: 1.25rem;
            border-top-right-radius: 0.25rem;
            box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.2);
        }

        .chat-bubble-admin {
            max-width: 75%;
            background: white;
            color: #1f2937;
            padding: 1rem 1.25rem;
            border-radius: 1.25rem;
            border-top-left-radius: 0.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
            border: 1px solid #f3f4f6;
        }

        .chat-bubble-text {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .chat-bubble-time {
            margin: 0.5rem 0 0 0;
            font-size: 0.7rem;
        }

        /* Input area */
        .chat-input-wrapper {
            padding: 1.25rem 1.5rem;
            border-top: 2px solid #f3f4f6;
            background: white;
        }

        .chat-input-form {
            display: flex;
            gap: 0.75rem;
        }

        .chat-text-input {
            flex: 1;
            padding: 0.875rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 1rem;
            outline: none;
            transition: all 0.2s;
            color: #374151;
            min-width: 0;
        }

        .chat-text-input:focus {
            border-color: #064e3b;
            box-shadow: 0 0 0 3px rgba(6, 78, 59, 0.15);
        }

        .chat-send-btn {
            padding: 0.875rem 1.75rem;
            background: linear-gradient(135deg, #064e3b, #043e2f);
            color: #ffffff;
            border: none;
            border-radius: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.625rem;
            transition: all 0.25s ease;
            font-size: 1rem;
            justify-content: center;
            white-space: nowrap;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
            letter-spacing: 0.025em;
            min-width: 120px;
        }

        /* Force white color on children */
        .chat-send-btn svg,
        .chat-send-btn span {
            color: #ffffff !important;
            fill: #ffffff !important;
        }

        .chat-send-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, #043e2f, #022c22);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(6, 78, 59, 0.35);
        }

        .chat-send-btn:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(6, 78, 59, 0.2);
        }

        .chat-send-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            box-shadow: none;
        }

        .chat-hint {
            margin: 0.75rem 0 0 0;
            font-size: 0.8rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .chat-footer-info {
            margin-top: 1rem;
            text-align: center;
        }

        .chat-footer-info p {
            margin: 0;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* ===== MOBILE RESPONSIVE ===== */
        @media (max-width: 640px) {
            .chat-page-wrapper {
                padding: 0.75rem 0.5rem;
            }

            .chat-card {
                border-radius: 0.75rem;
            }

            .chat-header {
                padding: 1rem;
                flex-direction: row;
                align-items: center;
            }

            .chat-header h1 {
                font-size: 1.1rem;
                margin-bottom: 0.25rem;
            }

            .chat-header-meta {
                font-size: 0.8rem;
            }

            .chat-status-badge {
                font-size: 0.7rem;
            }

            #chat-messages {
                height: calc(100vh - 280px);
                min-height: 300px;
                padding: 1rem 0.75rem;
                gap: 1rem;
            }

            .chat-bubble-user,
            .chat-bubble-admin {
                max-width: 90%;
                padding: 0.875rem 1rem;
            }

            .chat-bubble-text {
                font-size: 1rem;
                line-height: 1.7;
            }

            .chat-bubble-time {
                font-size: 0.75rem;
            }

            .chat-input-wrapper {
                padding: 0.75rem;
            }

            .chat-input-form {
                gap: 0.5rem;
            }

            .chat-text-input {
                padding: 0.75rem;
                font-size: 1rem;
            }

            .chat-send-btn {
                padding: 0.75rem 1.25rem;
                min-width: auto;
            }

            .chat-send-btn .btn-text {
                display: inline;
            }

            .chat-send-btn svg {
                width: 1.1rem;
                height: 1.1rem;
            }

            .chat-hint {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 380px) {
            #chat-messages {
                height: calc(100vh - 260px);
                padding: 0.75rem 0.5rem;
            }

            .chat-bubble-user,
            .chat-bubble-admin {
                max-width: 95%;
            }
        }
    </style>

    <div class="chat-page-wrapper">
        <!-- Alpine Chat Component -->
        <div x-data="chatSystem('{{ $session->tracking_code }}')">

            <!-- Chat Container -->
            <div class="chat-card">

                <!-- Header -->
                <div class="chat-header">
                    <div>
                        <h1>Chat Konseling</h1>
                        <p class="chat-header-meta">
                            <span>Kode: <span class="chat-tracking-code">{{ $session->tracking_code }}</span></span>
                            <span style="color: #9ca3af;">•</span>
                            <span class="chat-status-badge" style="@if($session->status == 'pending' || $session->status == 'in_progress') background: #fef3c7; color: #d97706;
                               @elseif($session->status == 'completed') background: #d1fae5; color: #064e3b;
                               @else background: #f3f4f6; color: #4b5563;
                               @endif">
                                @if($session->status == 'pending')
                                    Menunggu
                                @elseif($session->status == 'in_progress')
                                    Dalam Proses
                                @elseif($session->status == 'completed')
                                    Selesai
                                @else
                                    {{ ucfirst($session->status) }}
                                @endif
                            </span>
                        </p>
                    </div>
                    <a href="{{ route('home') }}" class="chat-exit-link">← Keluar</a>
                </div>

                <!-- Messages Area -->
                <div id="chat-messages">

                    <!-- Initial Issue (User Message - Right) -->
                    <div style="display: flex; justify-content: flex-end;">
                        <div class="chat-bubble-user">
                            <p class="chat-bubble-text">{{ $session->issue_description }}</p>
                            <p class="chat-bubble-time" style="text-align: left; opacity: 0.85;">
                                {{ $session->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Dynamic Messages -->
                    <template x-for="msg in messages" :key="msg.id">
                        <div style="display: flex; margin-bottom: 0.25rem;"
                            :style="{ justifyContent: msg.sender_type === 'user' ? 'flex-end' : 'flex-start' }">
                            <div :class="msg.sender_type === 'user' ? 'chat-bubble-user' : 'chat-bubble-admin'">
                                <p class="chat-bubble-text" x-text="msg.message"></p>
                                <p class="chat-bubble-time"
                                    :style="msg.sender_type === 'user' ? 'opacity: 0.85;' : 'color: #9ca3af;'"
                                    x-text="formatTime(msg.created_at)">
                                </p>
                            </div>
                        </div>
                    </template>

                </div>

                <!-- Input Area -->
                <div class="chat-input-wrapper">
                    @if($session->status !== 'completed')
                        <form @submit.prevent="sendMessage" class="chat-input-form">
                            <input type="text" x-model="newMessage" placeholder="Ketik pesan Anda..." required
                                :disabled="sending" class="chat-text-input">

                            <button type="submit" :disabled="sending || newMessage.trim() === ''" class="chat-send-btn">
                                <span class="btn-text">Kirim</span>
                                <svg style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </form>

                        <p class="chat-hint">
                            🔄 Pesan akan diperbarui secara otomatis setiap beberapa detik.
                        </p>
                    @else
                        <div
                            style="background: #f0fdf4; padding: 1rem; border-radius: 0.75rem; text-align: center; border: 1px solid #a7f3d0;">
                            <p style="margin: 0; color: #064e3b; font-size: 0.9rem; font-weight: 600;">Sesi konseling ini telah ditutup.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer Info -->
            <div class="chat-footer-info">
                <p>🔒 Pesan Anda terenkripsi end-to-end. Privasi Anda prioritas kami.</p>
            </div>
        </div>
    </div>

    <!-- Alpine Logic -->
    <script>
        function chatSystem(trackingCode) {
            return {
                messages: [],
                newMessage: '',
                sending: false,

                init() {
                    this.fetchMessages();
                    this.scrollToBottom();

                    // Auto refresh every 5 seconds
                    setInterval(() => {
                        this.fetchMessages(false);
                    }, 5000);
                },

                fetchMessages(forceScroll = true) {
                    fetch(`/counseling/${trackingCode}/messages`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const previousLength = this.messages.length;
                            this.messages = data;

                            if (forceScroll || this.messages.length > previousLength) {
                                this.scrollToBottom();
                            }
                        })
                        .catch(err => console.error('Fetch error:', err));
                },

                sendMessage() {
                    if (this.newMessage.trim() === '') return;

                    this.sending = true;
                    const message = this.newMessage;
                    this.newMessage = '';

                    // Get fresh CSRF token from meta tag
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

                    fetch(`/counseling/${trackingCode}/message`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('HTTP error ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            this.fetchMessages(true);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Restore the message so user doesn't lose it
                            this.newMessage = message;
                            alert('Gagal mengirim pesan. Silakan coba lagi.');
                        })
                        .finally(() => {
                            this.sending = false;
                        });
                },

                scrollToBottom() {
                    setTimeout(() => {
                        const container = document.getElementById('chat-messages');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    }, 100);
                },

                formatTime(timestamp) {
                    const date = new Date(timestamp);
                    return date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
        }
    </script>
@endsection