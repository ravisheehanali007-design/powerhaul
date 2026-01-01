<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran'; // Pastikan ini sesuai database
    public $incrementing = true; // Set true jika id_pembayaran adalah auto-increment
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['nik', 'tgl_pembayaran', 'pay_online', 'online_method'];
public function create()
{
    // Mengambil semua data pelanggan dari tabel pelanggan di MySQL
    $pelanggan = \App\Models\Pelanggan::all();

    return view('crud.create', $this->config + [
        'pelanggan' => $pelanggan
    ]);
}
public function pelanggan()
{
    // Relasi: Pembayaran dimiliki oleh Pelanggan (NIK -> NIK)
    return $this->belongsTo(Pelanggan::class, 'nik', 'nik');
}
public function detailPenyewaan() {
        return $this->hasMany(DetailPenyewaan::class, 'id_pembayaran', 'id_pembayaran');
    }
}