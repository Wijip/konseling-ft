<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPassword = 'password';

        $admins = [
            [
                'name' => 'Admin FT UNESA',
                'email' => 'admin@unesa.ac.id',
            ],
            [
                'name' => 'Nindya',
                'email' => 'nindya@unesa.ac.id',
            ],
            [
                'name' => 'Ammanda',
                'email' => 'ammanda@unesa.ac.id',
            ],
        ];

        foreach ($admins as $adminData) {
            User::updateOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'password' => Hash::make($adminPassword),
                    'role' => 'admin',
                ]
            );
        }
    }
}
