<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('barang.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
            $rules = [
        'username' => 'required|string',
        'password' => 'required|string',
    ];

    if (config('services.recaptcha.enabled')) {
        $rules['g-recaptcha-response'] = ['required', new Recaptcha];
    }

    $request->validate($rules);

    if (Auth::attempt($request->only('username', 'password'))) {
        $request->session()->regenerate();

        // 👇 SELALU ke barang.index (bukan intended, bukan pegawai)
        return redirect()->route('barang.index');
    }

    return back()
        ->withErrors(['login' => 'Username / Password Salah'])
        ->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
