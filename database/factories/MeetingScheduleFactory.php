<?php

namespace Database\Factories;

use App\Models\MeetingSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingScheduleFactory extends Factory
{
    protected $model = MeetingSchedule::class;

    public function definition()
    {
        return [
            'konselor_name' => $this->faker->name,
            'schedule_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'max_slots' => 5,
            'booked_slots' => 0,
            'is_available' => true,
        ];
    }
}
