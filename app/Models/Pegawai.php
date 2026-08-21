<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false; // tabel lama tidak punya created_at/updated_at

    protected $fillable = ['nama', 'jabatan', 'email', 'telepon', 'alamat'];
}
