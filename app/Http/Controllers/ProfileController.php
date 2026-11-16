<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user
     */
    public function show()
    {
        $user = auth()->user();

        // Hitung statistik untuk ditampilkan di profil
        $totalChat = $user->counselingSessions()->count();
        $totalMeetings = $user->meetingBookings()->count();
        $totalCounseling = $totalChat + $totalMeetings;

        return view('public.profile', compact(
            'user',
            'totalChat',
            'totalMeetings',
            'totalCounseling'
        ));
    }

    /**
     * Memperbarui data profil & foto avatar user
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:users,email,' . $user->id,
            'nim_nip'      => 'nullable|string|max:50',
            'rumpun'       => 'nullable|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'         => $request->name,
            'email'        => $request->email,
            'nim_nip'      => $request->nim_nip,
            'rumpun'       => $request->rumpun,
            'phone_number' => $request->phone_number,
        ];

        // Penanganan Upload Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Memperbarui password user
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.confirmed'                => 'Konfirmasi password baru tidak cocok.',
            'password.min'                      => 'Password minimal 8 karakter.',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}