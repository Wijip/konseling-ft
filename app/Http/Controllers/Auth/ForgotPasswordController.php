<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ForgotPasswordController extends Controller
{
    protected FonnteService $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    /**
     * Menampilkan formulir permintaan reset password via WhatsApp
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Mengirimkan kode OTP reset password ke WhatsApp pengguna
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
        ], [
            'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $user = User::findByPhone($request->phone_number);

        if (!$user) {
            return back()->withErrors([
                'phone_number' => 'Nomor WhatsApp tidak terdaftar dalam sistem.',
            ])->withInput();
        }

        // Generate 6 digit angka OTP
        $otp = sprintf('%06d', random_int(100000, 999999));

        // Simpan token/OTP ke tabel password_reset_tokens
        $tokenData = [
            'token'      => Hash::make($otp),
            'created_at' => Carbon::now(),
        ];

        if (Schema::hasColumn('password_reset_tokens', 'phone_number')) {
            $tokenData['phone_number'] = $user->phone_number;
        }

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            $tokenData
        );

        // Siapkan template pesan WhatsApp
        $message = "Halo *{$user->name}*,\n\n"
            . "Berikut adalah kode OTP untuk mereset password akun Konseling FT UNESA Anda:\n\n"
            . "*{$otp}*\n\n"
            . "Kode OTP ini berlaku selama 15 menit. Jangan bagikan kode ini kepada siapa pun demi keamanan akun Anda.\n\n"
            . "Jika Anda tidak merasa meminta reset password, silakan abaikan pesan ini.\n\n"
            . "Salam,\nKonseling FT UNESA";

        $response = $this->fonnteService->sendMessage($user->phone_number, $message);

        if (!$response['success']) {
            Log::error('Gagal mengirim WhatsApp OTP', [
                'user_id' => $user->id,
                'phone'   => $user->phone_number,
                'error'   => $response['message'],
            ]);

            return back()->withErrors([
                'phone_number' => 'Gagal mengirim kode OTP ke WhatsApp: ' . $response['message'],
            ])->withInput();
        }

        return redirect()->route('password.reset', ['phone' => $user->phone_number])
            ->with('status', 'Kode OTP reset password telah dikirimkan ke nomor WhatsApp Anda!');
    }

    /**
     * Alias method untuk kompatibilitas jika masih ada route/pemanggilan sendResetLinkEmail
     */
    public function sendResetLinkEmail(Request $request)
    {
        if ($request->has('phone_number')) {
            return $this->sendResetOtp($request);
        }

        if ($request->has('email')) {
            $user = User::where('email', $request->email)->first();
            if ($user && !empty($user->phone_number)) {
                $request->merge(['phone_number' => $user->phone_number]);
                return $this->sendResetOtp($request);
            }

            return back()->withErrors([
                'email' => 'Akun tidak ditemukan atau tidak memiliki nomor WhatsApp yang terdaftar.',
            ])->withInput();
        }

        return $this->sendResetOtp($request);
    }
}