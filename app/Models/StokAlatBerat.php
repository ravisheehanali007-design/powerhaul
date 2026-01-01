<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokAlatBerat extends Model
{
    // Nama tabel di database Anda
    protected $table = 'alatberat';

    // Matikan timestamps jika tabel Anda tidak punya kolom created_at/updated_at
    public $timestamps = false;

    // Tentukan Primary Key jika bukan 'id'
    protected $primaryKey = 'id_truk'; 
    public $incrementing = false; // Jika kode_alat berupa string/text
    protected $keyType = 'int';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'id_truk', 
        'nama_truk', 
        'merk', 
        'harga', 
        'tahun', 
        'status'
    ];
}