<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MeetingSchedule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tentukan password khusus admin di sini
        $adminPassword = 'password';

        User::updateOrCreate(
            ['email' => 'admin@unesa.ac.id'],
            [
                'name' => 'Admin FT UNESA',
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
            ]
        );

        $konselors = [
            [
                'name' => 'ERLINDA PERMATASARI',
                'email' => 'erlinda@inka.co.id',
            ],
            [
                'name' => 'SASKIA METTASASRI',
                'email' => 'saskia@inka.co.id',
            ],
            [
                'name' => 'EKIN AYU SAPUTRI',
                'email' => 'ekin@inka.co.id',
            ],
            [
                'name' => 'JOKO TRI HARTANTO',
                'email' => 'joko@inka.co.id',
            ],
        ];

        foreach ($konselors as $konselor) {
            User::firstOrCreate(
                ['email' => $konselor['email']],
                [
                    'name' => $konselor['name'],
                    'password' => Hash::make('password'),
                    'role' => 'konselor',
                ]
            );
        }

        // Create Schedules for next 2 days
        $startDate = Carbon::tomorrow();

        for ($i = 0; $i < 2; $i++) {
            $date = $startDate->copy()->addDays($i);

            if ($date->isWeekend())
                continue;

            // Session 1: 09:00 - 10:00
            MeetingSchedule::firstOrCreate([
                'konselor_name' => 'SASKIA METTASASRI',
                'schedule_date' => $date->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
            ], [
                'max_slots' => 1,
            ]);

            // Session 2: 13:00 - 14:00
            MeetingSchedule::firstOrCreate([
                'konselor_name' => 'EKIN AYU SAPUTRI',
                'schedule_date' => $date->format('Y-m-d'),
                'start_time' => '13:00:00',
                'end_time' => '14:00:00',
            ], [
                'max_slots' => 1,
            ]);
        }
    }
}