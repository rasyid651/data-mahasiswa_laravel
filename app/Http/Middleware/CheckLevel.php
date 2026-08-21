<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        // Cek apakah user sudah login
        if (! auth()->check()) {
            return redirect('/login')->with('error', 'Login dulu dong');
        }

        $level = auth()->user()->level;

        // Kalau level tidak diizinkan → JANGAN 403, arahkan ke halaman miliknya
        if (! in_array($level, $levels)) {
            if (in_array($level, [1, 2])) {
                // Admin & Operator Barang → ke Data Barang
                return redirect()->route('barang.index')
                    ->with('error', 'Perhatian anda tidak punya hak akses!');
            }

            if ($level == 3) {
                // Operator Mahasiswa → ke Data Mahasiswa
                return redirect()->route('mahasiswa.index')
                    ->with('error', 'Perhatian anda tidak punya hak akses!');
            }

            abort(403, 'Perhatian anda tidak punya hak akses!');
        }

        return $next($request);
    }
}
