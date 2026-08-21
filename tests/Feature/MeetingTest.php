<?php

namespace Tests\Feature;

use App\Models\MeetingBooking;
use App\Models\MeetingSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeetingTest extends TestCase
{
    use RefreshDatabase;

    // ==========================================
    // PUBLIC: Meeting Booking Flow
    // ==========================================

    /** @test */
    public function meeting_index_redirects_to_calendar()
    {
        $response = $this->get(route('meeting.index'));
        $response->assertRedirect(route('meeting.calendar'));
    }

    /** @test */
    public function it_shows_calendar_page()
    {
        $response = $this->get(route('meeting.calendar'));
        $response->assertStatus(200);
    }

    /** @test */
    public function calendar_shows_available_slots()
    {
        $schedule = MeetingSchedule::factory()->create([
            'schedule_date' => Carbon::tomorrow()->format('Y-m-d'),
            'is_available' => true,
            'max_slots' => 5,
            'booked_slots' => 0,
        ]);

        $response = $this->get(route('meeting.calendar', [
            'month' => Carbon::tomorrow()->month,
            'year' => Carbon::tomorrow()->year,
            'date' => Carbon::tomorrow()->format('Y-m-d'),
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('selectedDateSlots');
    }

    /** @test */
    public function it_shows_booking_form_for_available_slot()
    {
        $schedule = MeetingSchedule::factory()->create([
            'is_available' => true,
            'max_slots' => 5,
            'booked_slots' => 0,
        ]);

        $response = $this->get(route('meeting.create', $schedule));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_redirects_if_slot_is_full()
    {
        $schedule = MeetingSchedule::factory()->create([
            'is_available' => true,
            'max_slots' => 1,
            'booked_slots' => 1,
        ]);

        $response = $this->get(route('meeting.create', $schedule));
        $response->assertRedirect(route('meeting.calendar'));
    }

    /** @test */
    public function it_redirects_if_slot_is_unavailable()
    {
        $schedule = MeetingSchedule::factory()->create([
            'is_available' => false,
            'max_slots' => 5,
            'booked_slots' => 0,
        ]);

        $response = $this->get(route('meeting.create', $schedule));
        $response->assertRedirect(route('meeting.calendar'));
    }

    /** @test */
    public function it_can_submit_meeting_booking()
    {
        $schedule = MeetingSchedule::factory()->create([
            'is_available' => true,
            'max_slots' => 5,
            'booked_slots' => 0,
        ]);

        $response = $this->post(route('meeting.store'), [
            'meeting_schedule_id' => $schedule->id,
            'meeting_type' => 'offline',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'employee_id' => 'EMP002',
            'division' => 'HR',
            'jabatan' => 'Manager',
            'purpose' => 'Konseling karir',
        ]);

        $booking = MeetingBooking::first();
        $this->assertNotNull($booking);
        $this->assertEquals('pending', $booking->status);
        $this->assertStringStartsWith('MB-', $booking->tracking_code);

        // Booked slots should increment
        $schedule->refresh();
        $this->assertEquals(1, $schedule->booked_slots);

        $response->assertRedirect(route('tracking.show', ['code' => $booking->tracking_code]));
    }

    /** @test */
    public function it_prevents_booking_when_slot_is_full()
    {
        $schedule = MeetingSchedule::factory()->create([
            'is_available' => true,
            'max_slots' => 1,
            'booked_slots' => 1,
        ]);

        $response = $this->post(route('meeting.store'), [
            'meeting_schedule_id' => $schedule->id,
            'meeting_type' => 'online',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'employee_id' => 'EMP002',
            'division' => 'HR',
            'jabatan' => 'Manager',
            'purpose' => 'Test',
        ]);

        $response->assertSessionHasErrors();
        $this->assertEquals(0, MeetingBooking::count());
    }

    /** @test */
    public function it_validates_booking_form_fields()
    {
        $schedule = MeetingSchedule::factory()->create();

        $response = $this->post(route('meeting.store'), [
            'meeting_schedule_id' => $schedule->id,
            // Missing all required fields
        ]);

        $response->assertSessionHasErrors(['meeting_type', 'name', 'email', 'employee_id', 'division', 'jabatan', 'purpose']);
    }

    // ==========================================
    // MODEL: Auto-Complete Statuses
    // ==========================================

    /** @test */
    public function auto_complete_changes_approved_booking_to_completed_after_end_time()
    {
        $schedule = MeetingSchedule::factory()->create([
            'schedule_date' => Carbon::yesterday()->format('Y-m-d'),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
        ]);

        $booking = MeetingBooking::factory()->create([
            'meeting_schedule_id' => $schedule->id,
            'status' => 'approved',
        ]);

        MeetingBooking::autoCompleteStatuses();

        $booking->refresh();
        $this->assertEquals('completed', $booking->status);
    }

    /** @test */
    public function auto_complete_does_not_change_future_bookings()
    {
        $schedule = MeetingSchedule::factory()->create([
            'schedule_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        $booking = MeetingBooking::factory()->create([
            'meeting_schedule_id' => $schedule->id,
            'status' => 'approved',
        ]);

        MeetingBooking::autoCompleteStatuses();

        $booking->refresh();
        $this->assertEquals('approved', $booking->status);
    }

    /** @test */
    public function auto_complete_does_not_change_pending_bookings()
    {
        $schedule = MeetingSchedule::factory()->create([
            'schedule_date' => Carbon::yesterday()->format('Y-m-d'),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
        ]);

        $booking = MeetingBooking::factory()->create([
            'meeting_schedule_id' => $schedule->id,
            'status' => 'pending',
        ]);

        MeetingBooking::autoCompleteStatuses();

        $booking->refresh();
        $this->assertEquals('pending', $booking->status);
    }
}
