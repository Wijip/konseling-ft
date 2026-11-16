<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    protected FonnteService $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    /**
     * Menampilkan formulir input OTP dan password baru
     */
    public function showResetForm(Request $request, $token = null)
    {
        $phone = $request->query('phone') ?? session('phone');
        return view('admin.auth.reset-password', [
            'phone' => $phone,
            'token' => $token,
        ]);
    }

    /**
     * Verifikasi kode OTP dan perbarui password pengguna
     */
    public function reset(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp'          => 'required|string|size:6',
            'password'     => 'required|string|min:8|confirmed',
        ], [
            'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
            'otp.required'          => 'Kode OTP wajib diisi.',
            'otp.size'              => 'Kode OTP harus 6 digit angka.',
            'password.required'     => 'Password baru wajib diisi.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal 8 karakter.',
        ]);

        $user = User::findByPhone($request->phone_number);

        if (!$user) {
            return back()->withErrors([
                'phone_number' => 'Nomor WhatsApp tidak terdaftar dalam sistem.'
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // Cari record token di tabel password_reset_tokens berdasarkan email user
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors([
                'otp' => 'Permintaan reset password tidak ditemukan atau sudah kedaluwarsa. Silakan ajukan kode baru.'
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // Cek kedaluwarsa (15 menit)
        $createdAt = Carbon::parse($resetRecord->created_at);
        if ($createdAt->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            return back()->withErrors([
                'otp' => 'Kode OTP telah kedaluwarsa. Silakan minta kode OTP baru.'
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // Cek kecocokan OTP (support hashed maupun plain jika ada)
        if (!Hash::check($request->otp, $resetRecord->token) && $request->otp !== $resetRecord->token) {
            return back()->withErrors([
                'otp' => 'Kode OTP yang Anda masukkan salah.'
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // Perbarui password user
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        // Hapus token reset dari database
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        event(new PasswordReset($user));

        // Opsional: Kirim konfirmasi notifikasi ke WhatsApp pengguna
        $notifMessage = "Halo *{$user->name}*,\n\n"
            . "Password akun Konseling FT UNESA Anda telah berhasil diperbarui.\n\n"
            . "Jika Anda tidak merasa melakukan perubahan ini, segera hubungi admin sistem kami.\n\n"
            . "Salam,\nKonseling FT UNESA";
        $this->fonnteService->sendMessage($user->phone_number, $notifMessage);

        return redirect()->route('login')->with('status', 'Password berhasil diperbarui! Silakan masuk menggunakan password baru Anda.');
    }
}