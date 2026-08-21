<?php

namespace Database\Factories;

use App\Models\MeetingBooking;
use App\Models\MeetingSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingBookingFactory extends Factory
{
    protected $model = MeetingBooking::class;

    public function definition()
    {
        return [
            'tracking_code' => 'MB-' . $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'meeting_type' => $this->faker->randomElement(['online', 'offline']),
            'meeting_schedule_id' => MeetingSchedule::factory(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'employee_id' => $this->faker->numerify('EMP####'),
            'division' => 'HR',
            'jabatan' => 'Manager',
            'purpose' => $this->faker->sentence,
            'status' => 'pending',
        ];
    }
}
