<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    // Sesuaikan dengan nama tabel di database PHP lamamu
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    // Matikan timestamps bawaan Laravel karena tabel lamamu pakai kolom 'tanggal'
    public $timestamps = false;

    // Kolom yang boleh diisi massal (mass assignment)
    protected $fillable = [
        'nama', 'jumlah', 'harga', 'barcode', 'tanggal'
    ];
}
