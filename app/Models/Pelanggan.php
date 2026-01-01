<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pelanggan;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    
    // Memberitahu Laravel bahwa primary key adalah nik
    protected $primaryKey = 'nik';

    // WAJIB: Tambahkan ini jika NIK bukan auto-increment
    public $incrementing = false;

    // WAJIB: Tambahkan ini jika NIK bertipe string/varchar
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'nik', 'nama_pelanggan', 'country', 'city', 'phone', 'email', 'address'
    ];
    
    
}