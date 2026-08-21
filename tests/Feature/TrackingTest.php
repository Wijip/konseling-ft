<?php

namespace Tests\Feature;

use App\Models\CounselingSession;
use App\Models\MeetingBooking;
use App\Models\MeetingSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_tracking_search_page()
    {
        $response = $this->get(route('tracking.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_redirects_for_valid_counseling_tracking_code()
    {
        $session = CounselingSession::factory()->create();

        $response = $this->post(route('tracking.check'), [
            'tracking_code' => $session->tracking_code,
        ]);

        $response->assertRedirect(route('tracking.show', ['code' => strtoupper($session->tracking_code)]));
    }

    /** @test */
    public function it_redirects_for_valid_booking_tracking_code()
    {
        $schedule = MeetingSchedule::factory()->create();
        $booking = MeetingBooking::factory()->create(['meeting_schedule_id' => $schedule->id]);

        $response = $this->post(route('tracking.check'), [
            'tracking_code' => $booking->tracking_code,
        ]);

        $response->assertRedirect(route('tracking.show', ['code' => strtoupper($booking->tracking_code)]));
    }

    /** @test */
    public function it_returns_error_for_invalid_tracking_code()
    {
        $response = $this->post(route('tracking.check'), [
            'tracking_code' => 'INVALID-CODE-123',
        ]);

        $response->assertSessionHasErrors('tracking_code');
    }

    /** @test */
    public function it_shows_counseling_tracking_result()
    {
        $session = CounselingSession::factory()->create();

        $response = $this->get(route('tracking.show', ['code' => $session->tracking_code]));

        $response->assertStatus(200);
        $response->assertViewHas('type', 'counseling');
    }

    /** @test */
    public function it_shows_booking_tracking_result()
    {
        $schedule = MeetingSchedule::factory()->create();
        $booking = MeetingBooking::factory()->create(['meeting_schedule_id' => $schedule->id]);

        $response = $this->get(route('tracking.show', ['code' => $booking->tracking_code]));

        $response->assertStatus(200);
        $response->assertViewHas('type', 'meeting');
    }

    /** @test */
    public function it_redirects_for_nonexistent_tracking_show()
    {
        $response = $this->get(route('tracking.show', ['code' => 'DOES-NOT-EXIST']));
        $response->assertRedirect(route('tracking.index'));
    }
}
