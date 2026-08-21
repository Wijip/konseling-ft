<!DOCTYPE html>
<html>

<head>
    <title>Status Booking Pertemuan</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2
            style="color: {{ $booking->status === 'approved' ? '#16a34a' : ($booking->status === 'rejected' ? '#dc2626' : '#4f46e5') }};">
            Status Booking: {{ ucfirst($booking->status) }}
        </h2>
        <p>Halo {{ $booking->name }},</p>
        <p>Status pengajuan booking pertemuan Anda (Kode: <strong>{{ $booking->tracking_code }}</strong>) telah
            diperbarui.</p>

        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Topik:</strong> {{ $booking->purpose }}</p>
            <p><strong>Waktu:</strong> {{ $booking->schedule->schedule_date->translatedFormat('l, d F Y') }}
                ({{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }})
            </p>
            <p><strong>Status:</strong> <span
                    style="font-weight: bold; text-transform: uppercase;">{{ $booking->status }}</span></p>
        </div>

        <div
            style="background-color: #fef2f2; border: 1px solid #fecaca; padding: 20px; border-radius: 8px; margin: 30px 0; text-align: center;">
            <p style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #dc2626;">
                MOHON UNTUK DAPAT MELAKUKAN CEK WEBSITE COUNSELING CORNER SECARA BERKALA UNTUK MELIHAT BALASAN DARI
                KONSELOR
            </p>
        </div>

        <p>Terima kasih,<br>Tim Human Capital</p>
    </div>
</body>

</html>