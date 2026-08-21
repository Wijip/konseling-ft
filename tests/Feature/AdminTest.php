<?php

namespace Tests\Feature;

use App\Models\CounselingSession;
use App\Models\MeetingBooking;
use App\Models\MeetingSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->adminUser);
    }

    // ==========================================
    // DASHBOARD
    // ==========================================

    /** @test */
    public function it_shows_dashboard_with_stats()
    {
        CounselingSession::factory()->count(3)->create();
        $schedule = MeetingSchedule::factory()->create();
        MeetingBooking::factory()->count(2)->create(['meeting_schedule_id' => $schedule->id]);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalCounseling', 3);
        $response->assertViewHas('totalBooking', 2);
    }

    // ==========================================
    // ADMIN: Counseling Management
    // ==========================================

    /** @test */
    public function it_shows_counseling_sessions_list()
    {
        CounselingSession::factory()->count(3)->create();

        $response = $this->get(route('admin.counseling.index'));

        $response->assertStatus(200);
        $response->assertViewHas('sessions');
    }

    /** @test */
    public function it_shows_single_counseling_session()
    {
        $session = CounselingSession::factory()->create();

        $response = $this->get(route('admin.counseling.show', $session->id));

        $response->assertStatus(200);
        $response->assertViewHas('session');
    }

    /** @test */
    public function admin_can_update_counseling_status()
    {
        $session = CounselingSession::factory()->create(['status' => 'pending']);

        $response = $this->put(route('admin.counseling.update', $session->id), [
            'status' => 'in_progress',
        ]);

        $response->assertRedirect();
        $session->refresh();
        $this->assertEquals('in_progress', $session->status);
    }

    /** @test */
    public function admin_cannot_set_invalid_counseling_status()
    {
        $session = CounselingSession::factory()->create(['status' => 'pending']);

        $response = $this->put(route('admin.counseling.update', $session->id), [
            'status' => 'invalid_status',
        ]);

        $response->assertSessionHasErrors('status');
        $session->refresh();
        $this->assertEquals('pending', $session->status);
    }

    /** @test */
    public function admin_can_reply_to_counseling_session()
    {
        $session = CounselingSession::factory()->create(['status' => 'pending']);

        $response = $this->post(route('admin.counseling.reply', $session->id), [
            'message' => 'Terima kasih, kami akan membantu.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('counseling_messages', [
            'counseling_session_id' => $session->id,
            'sender_type' => 'konselor',
            'message' => 'Terima kasih, kami akan membantu.',
        ]);
    }

    /** @test */
    public function replying_auto_updates_pending_status_to_in_progress()
    {
        $session = CounselingSession::factory()->create(['status' => 'pending']);

        $this->post(route('admin.counseling.reply', $session->id), [
            'message' => 'Kami akan membantu.',
        ]);

        $session->refresh();
        $this->assertEquals('in_progress', $session->status);
    }

    /** @test */
    public function admin_cannot_reply_to_completed_session()
    {
        $session = CounselingSession::factory()->create(['status' => 'completed']);

        $response = $this->post(route('admin.counseling.reply', $session->id), [
            'message' => 'This should fail.',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(0, $session->messages()->count());
    }

    /** @test */
    public function admin_can_delete_counseling_session()
    {
        $session = CounselingSession::factory()->create();
        $session->messages()->create([
            'sender_type' => 'user',
            'message' => 'Test message',
        ]);

        $response = $this->delete(route('admin.counseling.destroy', $session->id));

        $response->assertRedirect(route('admin.counseling.index'));
        $this->assertDatabaseMissing('counseling_sessions', ['id' => $session->id]);
        $this->assertDatabaseMissing('counseling_messages', ['counseling_session_id' => $session->id]);
    }

    /** @test */
    public function admin_can_export_counseling_to_excel()
    {
        CounselingSession::factory()->count(3)->create();

        $response = $this->get(route('admin.counseling.export'));

        $response->assertStatus(200);
        $response->assertHeader(
            'content-type',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
    }

    // ==========================================
    // ADMIN: Booking Management
    // ==========================================

    /** @test */
    public function it_shows_booking_list()
    {
        $schedule = MeetingSchedule::factory()->create();
        MeetingBooking::factory()->count(2)->create(['meeting_schedule_id' => $schedule->id]);

        $response = $this->get(route('admin.bookings.index'));

        $response->assertStatus(200);
        $response->assertViewHas('bookings');
        $response->assertViewHas('konselorList');
    }

    /** @test */
    public function admin_can_approve_booking()
    {
        $schedule = MeetingSchedule::factory()->create();
        $booking = MeetingBooking::factory()->create([
            'meeting_schedule_id' => $schedule->id,
            'status' => 'pending',
        ]);

        $response = $this->put(route('admin.bookings.update', $booking->id), [
            'status' => 'approved',
            'admin_notes' => 'Disetujui, silakan datang tepat waktu.',
        ]);

        $response->assertRedirect();
        $booking->refresh();
        $this->assertEquals('approved', $booking->status);
        $this->assertEquals('Disetujui, silakan datang tepat waktu.', $booking->admin_notes);
    }

    /** @test */
    public function admin_can_reject_booking()
    {
        $schedule = MeetingSchedule::factory()->create();
        $booking = MeetingBooking::factory()->create([
            'meeting_schedule_id' => $schedule->id,
            'status' => 'pending',
        ]);

        $response = $this->put(route('admin.bookings.update', $booking->id), [
            'status' => 'rejected',
            'admin_notes' => 'Maaf, jadwal konselor berubah.',
        ]);

        $response->assertRedirect();
        $booking->refresh();
        $this->assertEquals('rejected', $booking->status);
    }

    /** @test */
    public function booking_status_must_be_valid()
    {
        $schedule = MeetingSchedule::factory()->create();
        $booking = MeetingBooking::factory()->create([
            'meeting_schedule_id' => $schedule->id,
            'status' => 'pending',
        ]);

        $response = $this->put(route('admin.bookings.update', $booking->id), [
            'status' => 'invalid_status',
        ]);

        $response->assertSessionHasErrors('status');
    }

    /** @test */
    public function admin_can_export_bookings_to_excel()
    {
        $schedule = MeetingSchedule::factory()->create();
        MeetingBooking::factory()->count(2)->create(['meeting_schedule_id' => $schedule->id]);

        $response = $this->get(route('admin.bookings.export'));

        $response->assertStatus(200);
        $response->assertHeader(
            'content-type',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
    }

    // ==========================================
    // ADMIN: Schedule Management
    // ==========================================

    /** @test */
    public function it_shows_schedule_list()
    {
        MeetingSchedule::factory()->count(3)->create();

        $response = $this->get(route('admin.schedules.index'));

        $response->assertStatus(200);
        $response->assertViewHas('schedules');
    }

    /** @test */
    public function it_shows_schedule_create_form()
    {
        $response = $this->get(route('admin.schedules.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_create_new_schedule()
    {
        $response = $this->post(route('admin.schedules.store'), [
            'konselor_name' => 'Dr. Smith',
            'schedule_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '10:00',
            'max_slots' => 3,
        ]);

        $response->assertRedirect(route('admin.schedules.index'));
        $this->assertDatabaseHas('meeting_schedules', [
            'konselor_name' => 'Dr. Smith',
            'max_slots' => 3,
            'is_available' => true,
        ]);
    }

    /** @test */
    public function schedule_validates_date_not_in_past()
    {
        $response = $this->post(route('admin.schedules.store'), [
            'konselor_name' => 'Dr. Smith',
            'schedule_date' => Carbon::yesterday()->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '10:00',
            'max_slots' => 3,
        ]);

        $response->assertSessionHasErrors('schedule_date');
    }

    /** @test */
    public function schedule_validates_end_time_after_start_time()
    {
        $response = $this->post(route('admin.schedules.store'), [
            'konselor_name' => 'Dr. Smith',
            'schedule_date' => Carbon::tomorrow()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '09:00', // Before start
            'max_slots' => 3,
        ]);

        $response->assertSessionHasErrors('end_time');
    }

    /** @test */
    public function admin_can_toggle_schedule_availability()
    {
        $schedule = MeetingSchedule::factory()->create(['is_available' => true]);

        $response = $this->put(route('admin.schedules.update', $schedule->id));

        $schedule->refresh();
        $this->assertFalse($schedule->is_available);

        // Toggle back
        $this->put(route('admin.schedules.update', $schedule->id));
        $schedule->refresh();
        $this->assertTrue($schedule->is_available);
    }

    /** @test */
    public function admin_can_delete_schedule_without_bookings()
    {
        $schedule = MeetingSchedule::factory()->create();

        $response = $this->delete(route('admin.schedules.destroy', $schedule->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('meeting_schedules', ['id' => $schedule->id]);
    }

    /** @test */
    public function admin_cannot_delete_schedule_with_bookings()
    {
        $schedule = MeetingSchedule::factory()->create();
        MeetingBooking::factory()->create(['meeting_schedule_id' => $schedule->id]);

        $response = $this->delete(route('admin.schedules.destroy', $schedule->id));

        $response->assertSessionHasErrors();
        $this->assertDatabaseHas('meeting_schedules', ['id' => $schedule->id]);
    }
}
