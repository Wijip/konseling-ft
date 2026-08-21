<!DOCTYPE html>
<html>

<head>
    <title>Balasan Konseling</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

        {{-- Header --}}
        <div style="text-align: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 2px solid #dc2626;">
            <h2 style="color: #dc2626; margin: 0; font-size: 1.5rem;">Counseling Corner</h2>
            <p style="color: #6b7280; margin: 5px 0 0; font-size: 0.85rem;">Layanan Konseling Human Capital</p>
        </div>

        {{-- Greeting --}}
        <p style="font-size: 1rem;">Halo <strong>{{ $session->name ?? 'Sobat Curhat' }}</strong>,</p>

        {{-- Notification --}}
        <p style="font-size: 1rem;">Chat konseling Anda telah <strong>dibalas oleh Konselor</strong>.</p>

        {{-- Tracking Code Box --}}
        <div
            style="background-color: #fef2f2; border: 1px solid #fecaca; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center;">
            <p style="margin: 0 0 8px; color: #6b7280; font-size: 0.85rem;">Kode Tracking Anda:</p>
            <p style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #dc2626; letter-spacing: 2px;">
                {{ $session->tracking_code }}
            </p>
        </div>

        {{-- Instructions --}}
        <div
            style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc2626;">
            <p style="margin: 0 0 10px; font-weight: 600; color: #111827;">Langkah untuk melihat & membalas chat:</p>
            <ol style="margin: 0; padding-left: 20px; color: #374151;">
                <li style="margin-bottom: 6px;">Buka website <strong>Counseling Corner</strong></li>
                <li style="margin-bottom: 6px;">Klik menu <strong>"Cek Status"</strong></li>
                <li style="margin-bottom: 6px;">Masukkan kode tracking: <strong>{{ $session->tracking_code }}</strong>
                </li>
                <li style="margin-bottom: 6px;">Klik <strong>"Buka Chat"</strong> untuk melihat dan membalas pesan</li>
            </ol>
        </div>

        {{-- Periodic Check Reminder --}}
        <div
            style="background-color: #fef2f2; border: 1px solid #fecaca; padding: 20px; border-radius: 8px; margin: 30px 0; text-align: center;">
            <p style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #dc2626;">
                MOHON UNTUK DAPAT MELAKUKAN CEK WEBSITE COUNSELING CORNER SECARA BERKALA UNTUK MELIHAT BALASAN DARI
                KONSELOR
            </p>
        </div>

        {{-- Footer --}}
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 25px 0;">
        <p style="color: #9ca3af; font-size: 0.8rem; text-align: center; margin: 0;">
            Email ini dikirim secara otomatis. Mohon tidak membalas email ini.<br>
            &copy; {{ date('Y') }} Counseling Corner - Tim Human Capital
        </p>
    </div>
</body>

</html>