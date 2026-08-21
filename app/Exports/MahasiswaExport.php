<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Mahasiswa::orderBy('id_mahasiswa', 'desc')->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Prodi', 'Jenis Kelamin', 'Telepon', 'Email', 'Alamat'];
    }

    public function map($mhs): array
    {
        static $no = 0;
        return [
            ++$no,
            $mhs->nama,
            $mhs->prodi,
            $mhs->jk,
            $mhs->telepon,
            $mhs->email,
            strip_tags($mhs->alamat ?? ''),
        ];
    }
}
