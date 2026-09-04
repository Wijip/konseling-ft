<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CounselorController extends Controller
{
    /**
     * Menampilkan daftar semua konselor.
     */
    public function index()
    {
        // Ambil data user dengan role konselor
        $counselors = User::where('role', 'konselor')->latest()->paginate(10);
        return view('admin.counselors.index', compact('counselors'));
    }

    /**
     * Menampilkan form tambah konselor baru.
     */
    public function create()
    {
        return view('admin.counselors.create');
    }

    /**
     * Menyimpan data konselor baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required'     => 'Nama konselor wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'konselor',
        ]);

        return redirect()->route('admin.counselors.index')->with('success', 'Konselor berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit data konselor.
     */
    public function edit(string $id)
    {
        $counselor = User::where('role', 'konselor')->findOrFail($id);
        return view('admin.counselors.edit', compact('counselor'));
    }

    /**
     * Memperbarui data konselor di database.
     */
    public function update(Request $request, string $id)
    {
        $counselor = User::where('role', 'konselor')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $counselor->id,
            'password' => 'nullable|string|min:8',
        ], [
            'name.required'  => 'Nama konselor wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah terdaftar.',
            'password.min'   => 'Password minimal 8 karakter.',
        ]);

        $counselor->name = $request->name;
        $counselor->email = $request->email;

        if ($request->filled('password')) {
            $counselor->password = Hash::make($request->password);
        }

        $counselor->save();

        return redirect()->route('admin.counselors.index')->with('success', 'Data konselor berhasil diperbarui.');
    }

    /**
     * Menghapus data konselor.
     */
    public function destroy(string $id)
    {
        $counselor = User::where('role', 'konselor')->findOrFail($id);
        $counselor->delete();

        return back()->with('success', 'Data konselor berhasil dihapus.');
    }
}