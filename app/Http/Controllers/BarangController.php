<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::orderBy('id_barang', 'desc');

        // Logika Filter Tanggal
        if ($request->has('filter') && $request->tgl_awal && $request->tgl_akhir) {
            $tgl_awal = $request->tgl_awal . " 00:00:00";
            $tgl_akhir = $request->tgl_akhir . " 23:59:59";
            $query->whereBetween('tanggal', [$tgl_awal, $tgl_akhir]);
        }

        // Pagination otomatis (3 data per halaman)
        $data_barang = $query->paginate(3)->appends($request->query());

        // Data untuk Chart.js
        $chart_barang = Barang::orderBy('id_barang', 'asc')->get();
        $namaBarang = $chart_barang->pluck('nama');
        $hargaBarang = $chart_barang->pluck('harga');

        return view('barang.index', compact('data_barang', 'namaBarang', 'hargaBarang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        Barang::create([
            'nama' => strip_tags($request->nama),
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'barcode' => rand(100000, 999999), // Auto generate barcode
            'tanggal' => Carbon::now()
        ]);

        return redirect()->route('barang.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update([
            'nama' => strip_tags($request->nama),
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        Barang::destroy($id);
        return redirect()->route('barang.index')->with('success', 'Data berhasil dihapus!');
    }
}
