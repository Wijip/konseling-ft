<?php

namespace Tests\Feature;

use App\Models\CounselingSession;
use App\Models\MeetingBooking;
use App\Models\MeetingSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->adminUser = User::factory()->create([
            'role' => 'admin', // Adjust based on your role implementation
        ]);

        // Authenticate as admin
        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function it_can_filter_counseling_sessions_by_status()
    {
        // Arrange
        CounselingSession::factory()->create(['status' => 'pending']);
        CounselingSession::factory()->create(['status' => 'in_progress']);
        CounselingSession::factory()->create(['status' => 'completed']);

        // Act: Filter by Pending
        $response = $this->get(route('admin.counseling.index', ['status' => 'pending']));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('sessions', function ($sessions) {
            return $sessions->count() === 1 && $sessions->first()->status === 'pending';
        });
    }

    /** @test */
    public function it_can_filter_counseling_sessions_by_identity()
    {
        // Arrange
        CounselingSession::factory()->create(['identity_type' => 'open']);
        CounselingSession::factory()->create(['identity_type' => 'anonymous']);

        // Act: Filter by Anonymous
        $response = $this->get(route('admin.counseling.index', ['identity' => 'anonymous']));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('sessions', function ($sessions) {
            return $sessions->count() === 1 && $sessions->first()->identity_type === 'anonymous';
        });
    }

    /** @test */
    public function it_can_filter_bookings_by_status()
    {
        // Arrange
        $schedule = MeetingSchedule::factory()->create();
        MeetingBooking::factory()->create(['status' => 'pending', 'meeting_schedule_id' => $schedule->id]);
        MeetingBooking::factory()->create(['status' => 'approved', 'meeting_schedule_id' => $schedule->id]);

        // Act: Filter by Approved
        $response = $this->get(route('admin.bookings.index', ['status' => 'approved']));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($bookings) {
            return $bookings->count() === 1 && $bookings->first()->status === 'approved';
        });
    }

    /** @test */
    public function it_can_filter_bookings_by_type()
    {
        // Arrange
        $schedule = MeetingSchedule::factory()->create();
        MeetingBooking::factory()->create(['meeting_type' => 'online', 'meeting_schedule_id' => $schedule->id]);
        MeetingBooking::factory()->create(['meeting_type' => 'offline', 'meeting_schedule_id' => $schedule->id]);

        // Act: Filter by Online
        $response = $this->get(route('admin.bookings.index', ['tipe' => 'online']));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($bookings) {
            return $bookings->count() === 1 && $bookings->first()->meeting_type === 'online';
        });
    }

    /** @test */
    public function it_can_filter_bookings_by_konselor()
    {
        // Arrange
        $scheduleA = MeetingSchedule::factory()->create(['konselor_name' => 'Konselor A']);
        $scheduleB = MeetingSchedule::factory()->create(['konselor_name' => 'Konselor B']);

        MeetingBooking::factory()->create(['meeting_schedule_id' => $scheduleA->id]);
        MeetingBooking::factory()->create(['meeting_schedule_id' => $scheduleB->id]);

        // Act: Filter by Konselor A
        $response = $this->get(route('admin.bookings.index', ['konselor' => 'Konselor A']));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('bookings', function ($bookings) {
            return $bookings->count() === 1 && $bookings->first()->schedule->konselor_name === 'Konselor A';
        });
    }
}
