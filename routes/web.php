<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

// ========== GUEST (belum login) ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ========== AUTHENTICATED (sudah login) ==========
Route::middleware('auth')->group(function () {

    // 👇 HALAMAN UTAMA: Redirect pintar sesuai level user
    Route::get('/', function () {
        $level = auth()->user()->level;

        if (in_array($level, [1, 2])) {
            // Admin & Operator Barang → masuk ke Data Barang
            return redirect()->route('barang.index');
        }

        if ($level == 3) {
            // Operator Mahasiswa → masuk ke Data Mahasiswa
            return redirect()->route('mahasiswa.index');
        }

        // Fallback kalau ada level lain di masa depan
        return redirect()->route('akun.index');
    });

    // Logout (semua level)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ---- AKUN (semua level, logika ditangani di controller) ----
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');

    // ---- BARANG (level 1 & 2) ----
    Route::middleware('check.level:1,2')->group(function () {
        Route::resource('barang', BarangController::class);
    });

    // ---- PEGAWAI (level 1 & 3, hanya lihat + realtime) ----
    Route::middleware('check.level:1,3')->group(function () {
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/live', [PegawaiController::class, 'live'])->name('pegawai.live');
    });

    // ---- MAHASISWA (level 1 & 3) ----
    Route::middleware('check.level:1,3')->group(function () {
        // ⚠️ WAJIB: POST (karena DataTables kirim POST), dan DI ATAS Route::resource
        Route::post('/mahasiswa/data', [MahasiswaController::class, 'serverSide'])->name('mahasiswa.data');

        Route::get('/mahasiswa/download-excel', [MahasiswaController::class, 'downloadExcel'])->name('mahasiswa.excel');
        Route::get('/mahasiswa/download-pdf', [MahasiswaController::class, 'downloadPdf'])->name('mahasiswa.pdf');

        Route::resource('mahasiswa', MahasiswaController::class);
    });

    // ---- EMAIL (semua level) ----
    Route::get('/email', [EmailController::class, 'index'])->name('email.index');
    Route::post('/email', [EmailController::class, 'kirim'])->name('email.kirim');
});
