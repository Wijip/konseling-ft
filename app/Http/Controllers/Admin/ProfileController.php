<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil admin.
     */
    public function edit()
    {
        $admin = auth()->user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Memperbarui data profil dan foto avatar admin.
     */
    public function update(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'phone_number' => 'nullable|string|max:20',
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan oleh pengguna lain.',
            'avatar.image'   => 'File harus berupa gambar.',
            'avatar.mimes'   => 'Format foto harus JPEG, PNG, JPG, atau GIF.',
            'avatar.max'     => 'Ukuran foto maksimal 2MB.',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone_number = $request->phone_number;

        // Proses unggah foto avatar
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $admin->avatar = $path;
        }

        $admin->save();

        return back()->with('success', 'Profil admin berhasil diperbarui.');
    }

    /**
     * Memperbarui password akun admin.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.min'              => 'Password baru minimal 8 karakter.',
            'password.confirmed'        => 'Konfirmasi password baru tidak cocok.',
        ]);

        $admin = auth()->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}