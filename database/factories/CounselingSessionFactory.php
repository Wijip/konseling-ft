<?php

namespace Database\Factories;

use App\Models\CounselingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class CounselingSessionFactory extends Factory
{
    protected $model = CounselingSession::class;

    public function definition()
    {
        return [
            'tracking_code' => 'CS-' . $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'employee_id' => $this->faker->numerify('EMP####'),
            'division' => 'IT',
            'identity_type' => $this->faker->randomElement(['open', 'anonymous']),
            'topic' => $this->faker->randomElement(['Pekerjaan', 'Keluarga']),
            'jabatan' => 'Staff',
            'issue_description' => $this->faker->sentence,
            'status' => 'pending',
        ];
    }
}
