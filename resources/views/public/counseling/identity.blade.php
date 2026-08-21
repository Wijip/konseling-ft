@extends('layouts.app')

@section('title', 'Pilih Status Identitas - Konseling FT UNESA')

@section('content')
    <div class="container" style="padding: 3rem 1rem; background-color: #f9fafb; min-height: calc(100vh - 160px);">
        
        <!-- Back Link -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('counseling.mode') }}"
                style="display: inline-flex; align-items: center; font-size: 0.875rem; font-weight: 600; color: #6b7280; text-decoration: none; transition: color 0.2s;"
                onmouseover="this.style.color='#064e3b'" onmouseout="this.style.color='#6b7280'">
                <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Pilih Mode
            </a>
        </div>

        {{-- Header Section --}}
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="color: #064e3b; font-size: 2.25rem; font-weight: 800; margin: 0 0 0.5rem 0;">
                Pilih Status Identitas
            </h1>
            <p style="color: #6b7280; font-size: 1rem; margin: 0;">
                Kami menghormati privasi Anda. Pilih bagaimana Anda ingin mengajukan konseling.
            </p>
        </div>

        {{-- Selection Cards Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 900px; margin: 0 auto;">
            
            <!-- Non-Anonim Card -->
            <a href="{{ route('counseling.create', ['type' => 'open']) }}"
                style="text-decoration: none; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; background: #ffffff; padding: 2.5rem 2rem; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.04);"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.08)'; this.style.borderColor='#064e3b';"
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.04)'; this.style.borderColor='#f3f4f6';">
                
                <div style="width: 4rem; height: 4rem; background-color: #e5e7eb; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <svg style="width: 2rem; height: 2rem; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                
                <h3 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0 0 0.5rem 0;">Non-Anonim</h3>
                <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.5; margin-bottom: 1.5rem;">
                    Identitas Anda akan diketahui oleh admin untuk memudahkan follow-up dan penanganan kasus.
                </p>
                
                <ul style="list-style: none; padding: 0; margin: 0 0 2rem 0; flex-grow: 1; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Penanganan lebih personal
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Menerima notifikasi via email
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Riwayat tersimpan di profil
                    </li>
                </ul>
                
                <div style="background: #064e3b; color: white; padding: 0.875rem 1.5rem; border-radius: 0.75rem; text-align: center; font-weight: 700; font-size: 0.95rem; transition: all 0.2s ease; margin-top: auto;"
                    onmouseover="this.style.background='#043e2f'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(6, 78, 59, 0.25)';"
                    onmouseout="this.style.background='#064e3b'; this.style.transform='none'; this.style.boxShadow='none';">
                    Lanjut sebagai Non-Anonim
                </div>
            </a>

            <!-- Anonim Card -->
            <a href="{{ route('counseling.create', ['type' => 'anonymous']) }}"
                style="text-decoration: none; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column; background: #ffffff; padding: 2.5rem 2rem; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px rgba(0,0,0,0.04);"
                onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.08)'; this.style.borderColor='#064e3b';"
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.04)'; this.style.borderColor='#f3f4f6';">
                
                <div style="width: 4rem; height: 4rem; background-color: #e5e7eb; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                    <svg style="width: 2rem; height: 2rem; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                
                <h3 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0 0 0.5rem 0;">Anonim</h3>
                <p style="color: #6b7280; font-size: 0.875rem; line-height: 1.5; margin-bottom: 1.5rem;">
                    Identitas Anda akan disembunyikan sepenuhnya. Cocok untuk whistleblowing atau isu sensitif.
                </p>

                <ul style="list-style: none; padding: 0; margin: 0 0 2rem 0; flex-grow: 1; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Privasi 100% terjaga
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Tidak perlu login / data diri
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.875rem; color: #374151; font-weight: 500;">
                        <svg style="width: 1.25rem; height: 1.25rem; color: #064e3b; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Melacak balasan menggunakan ID unik
                    </li>
                </ul>

                <div style="background: #064e3b; color: white; padding: 0.875rem 1.5rem; border-radius: 0.75rem; text-align: center; font-weight: 700; font-size: 0.95rem; transition: all 0.2s ease; margin-top: auto;"
                    onmouseover="this.style.background='#043e2f'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(6, 78, 59, 0.25)';"
                    onmouseout="this.style.background='#064e3b'; this.style.transform='none'; this.style.boxShadow='none';">
                    Lanjut sebagai Anonim
                </div>
            </a>
        </div>

        <!-- Privacy Banner -->
        <div style="max-width: 42rem; margin: 3rem auto 0;">
            <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 1rem 1.25rem; color: #064e3b;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <svg style="width: 1.25rem; height: 1.25rem; flex-shrink: 0; color: #064e3b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <p style="font-weight: 600; margin: 0; font-size: 0.875rem;">
                        Semua data konseling dienkripsi dan dijaga kerahasiaannya oleh tim HC.
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection