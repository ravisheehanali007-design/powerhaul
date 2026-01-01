<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenyewaan extends Model
{
    use HasFactory;

    protected $table = 'detailpenyewaan';
    protected $primaryKey = 'id_detail'; // Primary key tetap id_detail
    
    // PENTING: Set ke false karena kita input manual (no09, dll)
    public $incrementing = false; 
    
    // PENTING: Set ke string karena tipe datanya VARCHAR
    protected $keyType = 'string'; 

    public $timestamps = false;

    protected $fillable = [
        'id_detail', // Sekarang wajib masuk fillable karena diinput manual
        'id_pembayaran', 
        'id_truk', 
        'nik', 
        'status_sewa',
        'total',
        'pick_up',
        'return_date'
    ];
}