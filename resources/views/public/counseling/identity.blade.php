@extends('layouts.app')

@section('title', 'Pilih Status Identitas - Konseling FT UNESA')

@section('content')
    <div class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-[calc(100vh-160px)]">
        <div class="max-w-4xl mx-auto">
            
            {{-- Back Link --}}
            <div class="mb-8">
                <a href="{{ route('counseling.mode') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#064e3b] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Pilih Mode
                </a>
            </div>

            {{-- Header Section --}}
            <div class="text-center mb-10 sm:mb-12">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-[#064e3b] mb-3">
                    Pilih Status Identitas
                </h1>
                <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                    Kami menghormati privasi Anda. Pilih bagaimana Anda ingin mengajukan konseling.
                </p>
            </div>

            {{-- Selection Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                
                <!-- Non-Anonim Card -->
                <a href="{{ route('counseling.create', ['type' => 'open']) }}"
                    class="group bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-10 flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-2xl hover:border-[#064e3b] transition-all duration-300">
                    
                    <div>
                        <div class="w-16 h-16 bg-gray-200 group-hover:bg-[#064e3b]/10 rounded-2xl flex items-center justify-center mb-6 transition-colors">
                            <svg class="w-8 h-8 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Non-Anonim</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">
                            Identitas Anda akan diketahui oleh admin untuk memudahkan follow-up dan penanganan kasus.
                        </p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Penanganan lebih personal
                            </li>
                            <li class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Menerima notifikasi via email
                            </li>
                            <li class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Riwayat tersimpan di profil
                            </li>
                        </ul>
                    </div>

                    <div class="w-full bg-[#064e3b] group-hover:bg-[#04382a] text-white font-bold py-3.5 px-6 rounded-xl shadow-md transition-all text-center text-sm sm:text-base">
                        Lanjut sebagai Non-Anonim
                    </div>
                </a>

                <!-- Anonim Card -->
                <a href="{{ route('counseling.create', ['type' => 'anonymous']) }}"
                    class="group bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-10 flex flex-col justify-between hover:-translate-y-1.5 hover:shadow-2xl hover:border-[#064e3b] transition-all duration-300">
                    
                    <div>
                        <div class="w-16 h-16 bg-gray-200 group-hover:bg-[#064e3b]/10 rounded-2xl flex items-center justify-center mb-6 transition-colors">
                            <svg class="w-8 h-8 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Anonim</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-6">
                            Identitas Anda akan disembunyikan sepenuhnya. Cocok untuk whistleblowing atau isu sensitif.
                        </p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Privasi 100% terjaga
                            </li>
                            <li class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Tidak perlu login / data diri
                            </li>
                            <li class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                <svg class="w-5 h-5 text-[#064e3b] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                Melacak balasan menggunakan ID unik
                            </li>
                        </ul>
                    </div>

                    <div class="w-full bg-[#064e3b] group-hover:bg-[#04382a] text-white font-bold py-3.5 px-6 rounded-xl shadow-md transition-all text-center text-sm sm:text-base">
                        Lanjut sebagai Anonim
                    </div>
                </a>

            </div>

            <!-- Privacy Banner -->
            <div class="mt-10 max-w-2xl mx-auto">
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-[#064e3b] flex items-center justify-center sm:justify-start gap-3">
                    <svg class="w-5 h-5 shrink-0 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <p class="font-semibold text-xs sm:text-sm">
                        Semua data konseling dienkripsi dan dijaga kerahasiaannya oleh tim HC.
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection