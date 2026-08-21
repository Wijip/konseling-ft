<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Konseling FT UNESA</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.2cm;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 9px;
            color: #1f2937;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #064e3b;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header h2 {
            margin: 0;
            color: #064e3b;
            font-size: 15px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 3px 0 0 0;
            color: #4b5563;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 5px 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #064e3b;
            color: #ffffff;
            font-weight: bold;
            font-size: 8.5px;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-center { text-align: center; }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-open { background-color: #d1fae5; color: #065f46; }
        .badge-anonymous { background-color: #fef3c7; color: #92400e; }
        
        /* Badge Status Sesi */
        .badge-pending { background-color: #fef3c7; color: #d97706; }
        .badge-in_progress { background-color: #dbeafe; color: #1e40af; }
        .badge-completed { background-color: #d1fae5; color: #059669; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 8px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Rekapitulasi Sesi Konseling Online</h2>
        <p>Fakultas Teknik - Universitas Negeri Surabaya</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%" class="text-center">No</th>
                <th width="8%">Tracking</th>
                <th width="7%">Tanggal</th>
                <th width="6%">Identitas</th>
                <th width="10%">Nama Klien</th>
                <th width="8%">No. HP/WA</th>
                <th width="7%">Status Civitas</th>
                <th width="7%">NIM/NIP</th>
                <th width="8%">Rumpun</th>
                <th width="9%">Topik</th>
                <th width="19%">Keluhan / Konsultasi</th>
                <th width="8%" class="text-center">Status Sesi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $topicLabels = [
                    'Pekerjaan' => 'Masalah Pekerjaan / Karir',
                    'Keluarga'  => 'Masalah Keluarga / Pribadi',
                    'Hubungan'  => 'Hubungan dengan Rekan Kerja',
                    'Stress'    => 'Stress / Burnout',
                    'Lainnya'   => 'Lainnya',
                ];

                $statusLabels = [
                    'pending'     => 'Pending',
                    'in_progress' => 'Dalam Proses',
                    'completed'   => 'Selesai',
                    'rejected'    => 'Ditolak',
                ];
            @endphp
            @forelse($sessions as $index => $session)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $session->tracking_code }}</strong></td>
                    <td>{{ $session->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $session->identity_type == 'anonymous' ? 'badge-anonymous' : 'badge-open' }}">
                            {{ ucfirst($session->identity_type) }}
                        </span>
                    </td>
                    <td>{{ $session->identity_type == 'open' ? $session->name : 'Anonim' }}</td>
                    <td>{{ $session->identity_type == 'open' ? ($session->phone_number ?? '-') : '-' }}</td>
                    <td>{{ $session->identity_type == 'open' ? ($session->user_status ?? '-') : '-' }}</td>
                    <td>{{ $session->identity_type == 'open' ? ($session->employee_id ?? '-') : '-' }}</td>
                    <td>{{ $session->identity_type == 'open' ? ($session->division ?? '-') : '-' }}</td>
                    <td>{{ $topicLabels[$session->topic] ?? $session->topic }}</td>
                    <td>{{ $session->issue_description }}</td>
                    <td class="text-center">
                        <span class="badge badge-{{ $session->status }}">
                            {{ $statusLabels[$session->status] ?? ucfirst($session->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">Belum ada data konseling.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis pada: {{ date('d F Y H:i') }} WIB
    </div>
</body>
</html>