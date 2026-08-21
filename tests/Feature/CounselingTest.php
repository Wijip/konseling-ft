<?php

namespace Tests\Feature;

use App\Models\CounselingSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CounselingTest extends TestCase
{
    use RefreshDatabase;

    // ==========================================
    // PUBLIC: Counseling Flow
    // ==========================================

    /** @test */
    public function it_shows_counseling_mode_page()
    {
        $response = $this->get(route('counseling.mode'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_shows_identity_selection_page()
    {
        $response = $this->get(route('counseling.identity'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_shows_open_identity_form()
    {
        $response = $this->get(route('counseling.create', ['type' => 'open']));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_shows_anonymous_identity_form()
    {
        $response = $this->get(route('counseling.create', ['type' => 'anonymous']));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_404_for_invalid_identity_type()
    {
        $response = $this->get(route('counseling.create', ['type' => 'invalid']));
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_submit_open_counseling_form()
    {
        $response = $this->post(route('counseling.store'), [
            'identity_type' => 'open',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'employee_id' => 'EMP001',
            'division' => 'IT',
            'jabatan' => 'Staff',
            'topic' => 'Pekerjaan',
            'duration' => '30 menit',
            'issue_description' => 'Saya memiliki masalah pekerjaan.',
        ]);

        $session = CounselingSession::first();
        $this->assertNotNull($session);
        $this->assertEquals('open', $session->identity_type);
        $this->assertEquals('John Doe', $session->name);
        $this->assertEquals('pending', $session->status);
        $this->assertNotNull($session->tracking_code);
        $response->assertRedirect(route('counseling.confirmation', ['code' => $session->tracking_code]));
    }

    /** @test */
    public function it_can_submit_anonymous_counseling_form()
    {
        $response = $this->post(route('counseling.store'), [
            'identity_type' => 'anonymous',
            'topic' => 'Keluarga',
            'duration' => '30 menit',
            'issue_description' => 'Masalah keluarga saya.',
        ]);

        $session = CounselingSession::first();
        $this->assertNotNull($session);
        $this->assertEquals('anonymous', $session->identity_type);
        $this->assertNull($session->name);
        $this->assertNull($session->email);
        $response->assertRedirect(route('counseling.confirmation', ['code' => $session->tracking_code]));
    }

    /** @test */
    public function it_validates_required_fields_for_open_identity()
    {
        $response = $this->post(route('counseling.store'), [
            'identity_type' => 'open',
            // Missing name, email, etc.
            'topic' => 'Pekerjaan',
            'duration' => '30 menit',
            'issue_description' => 'Test',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'employee_id', 'division', 'jabatan']);
    }

    /** @test */
    public function it_validates_issue_description_is_required()
    {
        $response = $this->post(route('counseling.store'), [
            'identity_type' => 'anonymous',
            'topic' => 'Pekerjaan',
            'duration' => '30 menit',
            // Missing issue_description
        ]);

        $response->assertSessionHasErrors('issue_description');
    }

    /** @test */
    public function it_shows_confirmation_page_with_valid_code()
    {
        $session = CounselingSession::factory()->create();

        $response = $this->get(route('counseling.confirmation', ['code' => $session->tracking_code]));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_404_for_invalid_confirmation_code()
    {
        $response = $this->get(route('counseling.confirmation', ['code' => 'INVALID-CODE']));
        $response->assertStatus(404);
    }

    // ==========================================
    // PUBLIC: Chat System
    // ==========================================

    /** @test */
    public function it_shows_chat_page()
    {
        $session = CounselingSession::factory()->create();

        $response = $this->get(route('counseling.chat', ['code' => $session->tracking_code]));
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_send_message()
    {
        $session = CounselingSession::factory()->create(['status' => 'in_progress']);

        $response = $this->postJson(route('counseling.message', ['code' => $session->tracking_code]), [
            'message' => 'Hello, saya butuh bantuan.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('counseling_messages', [
            'counseling_session_id' => $session->id,
            'sender_type' => 'user',
            'message' => 'Hello, saya butuh bantuan.',
        ]);
    }

    /** @test */
    public function user_cannot_send_message_to_completed_session()
    {
        $session = CounselingSession::factory()->create(['status' => 'completed']);

        $response = $this->postJson(route('counseling.message', ['code' => $session->tracking_code]), [
            'message' => 'This should fail.',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function it_can_poll_messages()
    {
        $session = CounselingSession::factory()->create();
        $session->messages()->create([
            'sender_type' => 'user',
            'message' => 'Test message',
        ]);

        $response = $this->getJson(route('counseling.messages', ['code' => $session->tracking_code]));

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['message' => 'Test message']);
    }

    // ==========================================
    // MODEL: Auto Tracking Code Generation
    // ==========================================

    /** @test */
    public function tracking_code_is_auto_generated_on_create()
    {
        $session = CounselingSession::create([
            'identity_type' => 'anonymous',
            'topic' => 'Test',
            'duration' => '30 menit',
            'issue_description' => 'Test description',
            'status' => 'pending',
        ]);

        $this->assertNotNull($session->tracking_code);
        $this->assertStringStartsWith('CS-', $session->tracking_code);
    }
}
