<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin: semua akun. User lain: hanya akunnya sendiri (sesuai project lama)
        if ($user->level == 1) {
            $data_akun = Akun::all();
        } else {
            $data_akun = Akun::where('id_akun', $user->id_akun)->get();
        }

        return view('akun.index', compact('data_akun'));
    }

    // Hanya admin yang boleh tambah akun
    public function store(Request $request)
    {
        if (Auth::user()->level != 1) abort(403);

        $request->validate([
            'nama'     => 'required|string',
            'username' => 'required|string|unique:akun,username',
            'email'    => 'required|email|unique:akun,email',
            'password' => 'required|min:3',
            'level'    => 'required|in:1,2,3',
        ]);

        Akun::create([
            'nama'     => strip_tags($request->nama),
            'username' => strip_tags($request->username),
            'email'    => strip_tags($request->email),
            'password' => Hash::make($request->password), // auto hash
            'level'    => $request->level,
        ]);

        return redirect()->route('akun.index')->with('success', 'Berhasil menambahkan akun!');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $akun = Akun::findOrFail($id);

        // Non-admin hanya boleh edit akunnya sendiri
        if ($user->level != 1 && $akun->id_akun != $user->id_akun) {
            abort(403);
        }

        $request->validate([
            'nama'     => 'required|string',
            'username' => 'required|string|unique:akun,username,' . $id . ',id_akun',
            'email'    => 'required|email|unique:akun,email,' . $id . ',id_akun',
            'password' => 'nullable|min:3', // nullable: boleh dikosongkan
            'level'    => 'required|in:1,2,3',
        ]);

        $data = [
            'nama'     => strip_tags($request->nama),
            'username' => strip_tags($request->username),
            'email'    => strip_tags($request->email),
            'level'    => $request->level,
        ];

        // Hash password baru kalau diisi. Kalau kosong, password tidak diubah
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $akun->update($data);

        return redirect()->route('akun.index')->with('success', 'Berhasil mengedit akun!');
    }

    // Hanya admin yang boleh hapus
    public function destroy($id)
    {
        if (Auth::user()->level != 1) abort(403);
        Akun::destroy($id);
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}
