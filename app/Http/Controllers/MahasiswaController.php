<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    // Halaman utama
    public function index()
    {
        return view('mahasiswa.index');
    }

    // DataTables server-side (pengganti mahasiswa-serverside.php)
    public function serverSide(Request $request)
    {
        $columns = ['id_mahasiswa', 'nama', 'prodi', 'jk', 'telepon', 'id_mahasiswa'];

        $totalData = Mahasiswa::count();
        $query = Mahasiswa::select('id_mahasiswa', 'nama', 'prodi', 'jk', 'telepon');

        // Search
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();

        // Order
        $orderCol = $columns[$request->input('order.0.column') ?? 0] ?? 'id_mahasiswa';
        $orderDir = $request->input('order.0.dir') ?? 'DESC';
        $query->orderBy($orderCol, $orderDir);

        // Limit
        $limit = $request->input('length') ?? 10;
        $start = $request->input('start') ?? 0;
        $data = $query->skip($start)->take($limit)->get();

        // Format data untuk DataTables
        $rows = [];
        $no = $start + 1;
        foreach ($data as $mhs) {
            $aksi = '
                <div width="20%" class="text-center">
                    <a href="'.route('mahasiswa.show', $mhs->id_mahasiswa).'" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="'.route('mahasiswa.edit', $mhs->id_mahasiswa).'" class="btn btn-success btn-sm">
                        <i class="fas fa-edit"></i> Ubah
                    </a>
                    <form action="'.route('mahasiswa.destroy', $mhs->id_mahasiswa).'" method="POST" class="d-inline"
                        onsubmit="return confirm(\'Yakin ingin menghapus mahasiswa?\')">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>';

            $rows[] = [
                'no' => $no++,
                'nama' => $mhs->nama,
                'prodi' => $mhs->prodi,
                'jk' => $mhs->jk,
                'telepon' => $mhs->telepon,
                'aksi' => $aksi,
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $rows,
        ]);
    }

    // Form tambah
    public function create()
    {
        return view('mahasiswa.create');
    }

    // Proses tambah (dengan upload foto)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'prodi' => 'required|string',
            'jk' => 'required|in:laki-laki,perempuan',
            'telepon' => 'required',
            'alamat' => 'nullable',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'prodi', 'jk', 'telepon', 'alamat', 'email']);

        // Upload foto kalau ada
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $ext = $file->getClientOriginalExtension();
            $namaFileBaru = uniqid().'.'.$ext;
            $file->move(public_path('assets/img'), $namaFileBaru);
            $data['foto'] = $namaFileBaru;
        }

        Mahasiswa::create($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Halaman detail
    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        return view('mahasiswa.show', compact('mahasiswa'));
    }

    // Form ubah
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    // Proses ubah (dengan upload foto baru + hapus lama)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'prodi' => 'required|string',
            'jk' => 'required|in:laki-laki,perempuan',
            'telepon' => 'required',
            'alamat' => 'nullable',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $data = $request->only(['nama', 'prodi', 'jk', 'telepon', 'alamat', 'email']);

        // Upload foto baru (kalau ada)
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            // Hapus foto lama
            $fotoLama = public_path('assets/img/'.$request->fotoLama);
            if (File::exists($fotoLama) && $request->fotoLama) {
                File::delete($fotoLama);
            }

            $file = $request->file('foto');
            $ext = $file->getClientOriginalExtension();
            $namaFileBaru = uniqid().'.'.$ext;
            $file->move(public_path('assets/img'), $namaFileBaru);
            $data['foto'] = $namaFileBaru;
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diedit!');
    }

    // Hapus (dengan hapus file foto)
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Hapus file foto dari server
        $fotoPath = public_path('assets/img/'.$mahasiswa->foto);
        if (File::exists($fotoPath) && $mahasiswa->foto) {
            File::delete($fotoPath);
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus!');
    }

    public function downloadExcel()
    {
        return Excel::download(new MahasiswaExport, 'data-mahasiswa.xlsx');
    }

    public function downloadPdf()
    {
        $data_mahasiswa = Mahasiswa::orderBy('id_mahasiswa', 'desc')->get();
        $pdf = Pdf::loadView('mahasiswa.pdf', compact('data_mahasiswa'));

        return $pdf->download('data-mahasiswa.pdf');
    }
}
