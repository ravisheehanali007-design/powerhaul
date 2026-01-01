<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'invoice';

    /**
     * Nama primary key.
     */
    protected $primaryKey = 'id_invoice';

    /**
     * Tentukan apakah primary key auto-increment.
     * Set ke false jika id_invoice berupa string (contoh: INV-001).
     */
    public $incrementing = true;

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     * Disesuaikan dengan $fields di Controller Anda.
     */
    protected $fillable = [
        'id_invoice',
        'fname',
        'nama_truk',
        'qty',
        'total',
        'online_method', // Nama kolom disesuaikan menjadi online_method
        'status',
        'created_at',
    ];

    /**
     * Menonaktifkan timestamps otomatis (created_at & updated_at) 
     * jika Anda ingin mengisi 'created_at' secara manual atau 
     * tabel tidak memiliki kolom 'updated_at'.
     */
    public $timestamps = true;
}