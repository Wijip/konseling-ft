<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CounselingExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
            'Tanggal',
            'Waktu',
            'Identitas',
            'Nama',
            'Email',
            'No. HP / WhatsApp',
            'Status Civitas',
            'NIM / NIP',
            'Rumpun (Divisi)',
            'Prodi (Jabatan)',
            'Topik',
            'Durasi',
            'Deskripsi Masalah',
            'Status',
        ];
    }

    public function map($session): array
    {
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

        $topic = $topicLabels[$session->topic] ?? $session->topic ?? '-';
        $status = $statusLabels[$session->status] ?? ucfirst($session->status);

        $identity    = $session->identity_type == 'anonymous' ? 'Anonim' : 'Terbuka';
        $name        = $session->identity_type == 'anonymous' ? 'Disembunyikan' : $session->name;
        $email       = $session->identity_type == 'anonymous' ? '-' : $session->email;
        $phoneNumber = $session->identity_type == 'anonymous' ? '-' : ($session->phone_number ?? '-');
        $userStatus  = $session->identity_type == 'anonymous' ? '-' : ($session->user_status ?? '-');
        $nip         = $session->identity_type == 'anonymous' ? '-' : $session->employee_id;
        $divisi      = $session->identity_type == 'anonymous' ? '-' : $session->division;
        $jabatan     = $session->identity_type == 'anonymous' ? '-' : $session->jabatan;

        return [
            $session->tracking_code,
            $session->created_at->format('Y-m-d'),
            $session->created_at->format('H:i:s'),
            $identity,
            $name,
            $email,
            $phoneNumber,
            $userStatus,
            $nip,
            $divisi,
            $jabatan,
            $topic,
            $session->duration ? $session->duration : '-',
            $session->issue_description,
            $status,
        ];
    }
}