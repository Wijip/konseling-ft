<?php

namespace Database\Factories;

use App\Models\CounselingMessage;
use App\Models\CounselingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class CounselingMessageFactory extends Factory
{
    protected $model = CounselingMessage::class;

    public function definition()
    {
        return [
            'counseling_session_id' => CounselingSession::factory(),
            'sender_type' => $this->faker->randomElement(['user', 'konselor']),
            'message' => $this->faker->sentence,
        ];
    }
}
