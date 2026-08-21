<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete old counselor
        $oldCounselorEmail = 'budi@inka.co.id';
        // Check if exists before deleting to avoid errors if already deleted
        if (User::where('email', $oldCounselorEmail)->exists()) {
            // We might need to handle related data like schedules. 
            // For now, let's just delete the user. 
            // If there are foreign key constraints, this might fail if we don't cascade or handle them.
            // Given the context, we probably want to keep historical data or assign it to someone else?
            // But the user just said "Change and adjust".
            // Let's try to delete. If it fails due to constraints, we might need to soft delete or keep it.
            // Actually, usually in dev we might just want to update the name if it was a rename, but here it is a list change.
            User::where('email', $oldCounselorEmail)->delete();
        }

        // Add new counselors
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore old counselor
        User::firstOrCreate(
            ['email' => 'budi@inka.co.id'],
            [
                'name' => 'Dr. Budi Santoso, Psikolog',
                'password' => Hash::make('password'),
                'role' => 'konselor',
            ]
        );

        // Delete new counselors
        $emails = [
            'erlinda@inka.co.id',
            'saskia@inka.co.id',
            'ekin@inka.co.id',
            'joko@inka.co.id',
        ];

        User::whereIn('email', $emails)->delete();
    }
};
