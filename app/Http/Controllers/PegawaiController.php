<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
        // pengganti pegawai.php (halaman tampil data)
    public function index()
    {
        return view('pegawai.index');
    }

    // pengganti realtime-pegawai.php (dipanggil AJAX tiap 2 detik)
    public function live()
    {
        $data_pegawai = Pegawai::orderBy('id_pegawai', 'desc')->get();
        return view('pegawai.live', compact('data_pegawai'));
    }
}
