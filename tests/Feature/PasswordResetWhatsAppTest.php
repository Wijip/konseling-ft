<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordResetWhatsAppTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_forgot_password_page()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Lupa Password');
        $response->assertSee('phone_number');
    }

    /** @test */
    public function request_otp_fails_if_phone_number_is_not_registered()
    {
        $response = $this->post(route('password.phone'), [
            'phone_number' => '089999999999',
        ]);

        $response->assertSessionHasErrors('phone_number');
    }

    /** @test */
    public function request_otp_succeeds_and_saves_otp_for_registered_user()
    {
        $user = User::factory()->create([
            'phone_number' => '081234567890',
            'role'         => 'user',
        ]);

        $response = $this->post(route('password.phone'), [
            'phone_number' => '081234567890',
        ]);

        $response->assertRedirect(route('password.reset', ['phone' => '081234567890']));
        $response->assertSessionHas('status');

        // Pastikan token OTP tercatat di database
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function request_otp_works_with_different_phone_format()
    {
        $user = User::factory()->create([
            'phone_number' => '081234567890',
            'role'         => 'user',
        ]);

        // Input menggunakan format +62
        $response = $this->post(route('password.phone'), [
            'phone_number' => '+6281234567890',
        ]);

        $response->assertRedirect(route('password.reset', ['phone' => '081234567890']));

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function reset_password_fails_with_invalid_otp()
    {
        $user = User::factory()->create([
            'phone_number' => '081234567890',
            'role'         => 'user',
        ]);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token'      => Hash::make('123456'),
                'created_at' => Carbon::now(),
            ]
        );

        $response = $this->post(route('password.update'), [
            'phone_number'          => '081234567890',
            'otp'                   => '999999', // salah
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors('otp');
    }

    /** @test */
    public function reset_password_fails_if_otp_is_expired()
    {
        $user = User::factory()->create([
            'phone_number' => '081234567890',
            'role'         => 'user',
        ]);

        // Token dibuat 20 menit lalu (kedaluwarsa)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token'      => Hash::make('123456'),
                'created_at' => Carbon::now()->subMinutes(20),
            ]
        );

        $response = $this->post(route('password.update'), [
            'phone_number'          => '081234567890',
            'otp'                   => '123456',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors('otp');
    }

    /** @test */
    public function user_can_successfully_reset_password_with_valid_otp()
    {
        $user = User::factory()->create([
            'phone_number' => '081234567890',
            'password'     => Hash::make('oldpassword123'),
            'role'         => 'user',
        ]);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token'      => Hash::make('654321'),
                'created_at' => Carbon::now(),
            ]
        );

        $response = $this->post(route('password.update'), [
            'phone_number'          => '081234567890',
            'otp'                   => '654321',
            'password'              => 'newsecret123',
            'password_confirmation' => 'newsecret123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');

        // Pastikan token reset sudah dihapus
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);

        // Pastikan password user sudah berubah
        $user->refresh();
        $this->assertTrue(Hash::check('newsecret123', $user->password));
    }

    /** @test */
    public function register_validates_and_stores_phone_number()
    {
        // 1. Gagal jika phone_number kosong
        $failResponse = $this->post(route('register.store'), [
            'name'                  => 'John Doe',
            'email'                 => 'johndoe@example.com',
            'phone_number'          => '',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $failResponse->assertSessionHasErrors('phone_number');

        // 2. Berhasil jika phone_number valid
        $successResponse = $this->post(route('register.store'), [
            'name'                  => 'John Doe',
            'email'                 => 'johndoe@example.com',
            'phone_number'          => '081234567899',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $successResponse->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', [
            'email'        => 'johndoe@example.com',
            'phone_number' => '081234567899',
        ]);
    }
}
