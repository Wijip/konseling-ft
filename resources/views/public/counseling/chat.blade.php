@extends('layouts.app')

@section('title', 'Chat Konseling - Konseling FT UNESA')

@section('content')
    <div class="py-6 sm:py-10 px-3 sm:px-6 lg:px-8 bg-gray-50/50 min-h-[calc(100vh-160px)] flex flex-col justify-center">
        <div class="w-full max-w-4xl mx-auto">
            
            <!-- Alpine Chat Component -->
            <div x-data="chatSystem('{{ $session->tracking_code }}')">

                <!-- Chat Container Card -->
                <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-100 shadow-xl overflow-hidden flex flex-col">

                    <!-- Header -->
                    <div class="px-4 sm:px-6 py-4 border-b border-gray-100 flex items-center justify-between gap-3 bg-white">
                        <div class="min-w-0">
                            <h1 class="text-base sm:text-xl font-extrabold text-[#064e3b] truncate">
                                Chat Konseling
                            </h1>
                            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mt-0.5 flex-wrap">
                                <span>Kode: <span class="font-mono font-bold text-[#064e3b]">{{ $session->tracking_code }}</span></span>
                                <span class="text-gray-300">•</span>
                                <span class="font-bold text-[11px] sm:text-xs px-2.5 py-0.5 rounded-full whitespace-nowrap
                                    @if($session->status == 'pending' || $session->status == 'in_progress') bg-amber-100 text-amber-700
                                    @elseif($session->status == 'completed') bg-emerald-100 text-[#064e3b]
                                    @else bg-gray-100 text-gray-600
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
                            </div>
                        </div>

                        <a href="{{ route('home') }}" class="text-xs sm:text-sm font-semibold text-gray-500 hover:text-[#064e3b] transition-colors shrink-0">
                            ← Keluar
                        </a>
                    </div>

                    <!-- Messages Area -->
                    <div id="chat-messages" class="bg-gray-50/70 p-4 sm:p-6 h-[420px] sm:h-[500px] overflow-y-auto flex flex-col gap-4 scroll-smooth">

                        <!-- Initial Issue (User Message - Right) -->
                        <div class="flex justify-end">
                            <div class="max-w-[88%] sm:max-w-[75%] bg-[#064e3b] text-white p-3.5 sm:p-4 rounded-2xl rounded-tr-none shadow-sm">
                                <p class="text-xs sm:text-sm leading-relaxed whitespace-pre-wrap break-words">{{ $session->issue_description }}</p>
                                <p class="text-[10px] sm:text-xs mt-1.5 opacity-75 text-left">
                                    {{ $session->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Dynamic Messages -->
                        <template x-for="msg in messages" :key="msg.id">
                            <div class="flex" :class="msg.sender_type === 'user' ? 'justify-end' : 'justify-start'">
                                <div :class="msg.sender_type === 'user' 
                                    ? 'max-w-[88%] sm:max-w-[75%] bg-[#064e3b] text-white p-3.5 sm:p-4 rounded-2xl rounded-tr-none shadow-sm' 
                                    : 'max-w-[88%] sm:max-w-[75%] bg-white text-gray-800 p-3.5 sm:p-4 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm'">
                                    
                                    <p class="text-xs sm:text-sm leading-relaxed whitespace-pre-wrap break-words" x-text="msg.message"></p>
                                    <p class="text-[10px] sm:text-xs mt-1.5"
                                        :class="msg.sender_type === 'user' ? 'opacity-75' : 'text-gray-400'"
                                        x-text="formatTime(msg.created_at)">
                                    </p>
                                </div>
                            </div>
                        </template>

                    </div>

                    <!-- Input Area -->
                    <div class="p-3.5 sm:p-5 border-t border-gray-100 bg-white">
                        @if($session->status !== 'completed')
                            <form @submit.prevent="sendMessage" class="flex items-center gap-2.5">
                                <input type="text" x-model="newMessage" placeholder="Ketik pesan Anda..." required
                                    :disabled="sending" 
                                    class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-[#064e3b] focus:ring-2 focus:ring-[#064e3b]/20 transition-all text-gray-700 placeholder-gray-400 disabled:bg-gray-100">

                                <button type="submit" :disabled="sending || newMessage.trim() === ''" 
                                    class="bg-[#064e3b] hover:bg-[#043e2f] text-white px-4 sm:px-6 py-3 rounded-xl font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition-all shadow-md active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed shrink-0 min-w-[85px] sm:min-w-[110px] cursor-pointer">
                                    <span>Kirim</span>
                                    <svg class="w-4 h-4 shrink-0 fill-current" viewBox="0 0 24 24">
                                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                    </svg>
                                </button>
                            </form>

                            <p class="mt-2 text-[11px] sm:text-xs text-gray-400 flex items-center gap-1">
                                <span>🔄 Pesan akan diperbarui secara otomatis setiap beberapa detik.</span>
                            </p>
                        @else
                            <div class="bg-emerald-50/70 p-3.5 rounded-xl text-center border border-emerald-100">
                                <p class="text-xs sm:text-sm text-[#064e3b] font-semibold">Sesi konseling ini telah ditutup.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="mt-4 text-center">
                    <p class="text-[11px] sm:text-xs text-gray-400">🔒 Pesan Anda terenkripsi end-to-end. Privasi Anda prioritas kami.</p>
                </div>
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