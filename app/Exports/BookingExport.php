<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class BookingExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Kode Tracking',
            'Tipe Pertemuan',
            'Tanggal Jadwal',
            'Waktu',
            'Konselor',
            'Nama',
            'Email',
            'NIP',
            'Divisi',
            'Jabatan',
            'Tujuan',
            'Status',
            'Catatan Admin',
        ];
    }

    public function map($booking): array
    {
        $statusLabels = [
            'pending' => 'Pending',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
        ];

        $typeLabel = $booking->meeting_type == 'online' ? 'Online' : 'Langsung';
        $status = $statusLabels[$booking->status] ?? ucfirst($booking->status);

        $scheduleDate = $booking->schedule ? $booking->schedule->schedule_date->format('Y-m-d') : '-';
        $time = '-';
        if ($booking->schedule) {
            $start = Carbon::parse($booking->schedule->start_time)->format('H:i');
            $end = Carbon::parse($booking->schedule->end_time)->format('H:i');
            $time = "$start - $end";
        }
        $konselor = $booking->schedule->konselor_name ?? '-';

        return [
            $booking->tracking_code,
            $typeLabel,
            $scheduleDate,
            $time,
            $konselor,
            $booking->name,
            $booking->email,
            $booking->employee_id,
            $booking->division,
            $booking->jabatan,
            $booking->purpose,
            $status,
            $booking->admin_notes,
        ];
    }
}
