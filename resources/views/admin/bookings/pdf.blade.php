<!DOCTYPE html>
<html>
<head>
    <title>Laporan Booking Pertemuan</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #064e3b; color: white; font-weight: bold; }
        h2 { text-align: center; color: #064e3b; margin-bottom: 5px; }
        p { text-align: center; color: #666; margin-top: 0; }
    </style>
</head>
<body>
    <h2>LAPORAN BOOKING PERTEMUAN KONSELING</h2>
    <p>Fakultas Teknik - UNESA</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tracking</th>
                <th>Tipe</th>
                <th>Tanggal & Jam</th>
                <th>Konselor</th>
                <th>Nama Pemohon</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $booking->tracking_code }}</td>
                    <td>{{ ucfirst($booking->meeting_type) }}</td>
                    <td>
                        {{ $booking->schedule->schedule_date->format('d/m/Y') }}
                        ({{ substr($booking->schedule->start_time, 0, 5) }} - {{ substr($booking->schedule->end_time, 0, 5) }})
                    </td>
                    <td>{{ $booking->schedule->konselor_name ?? '-' }}</td>
                    <td>{{ $booking->name }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>