<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $config = [
        'title'  => 'Pembayaran',
        'route'  => 'pembayaran',
        'fields' => [
            'nik',           
            'tgl_pembayaran', 
            'jumlah_sewa',    
            'pay_online',     
            'online_method'   
        ],
    ];

    public function index() {
    $data = \DB::table('pembayaran')
            ->join('pelanggan', 'pembayaran.nik', '=', 'pelanggan.nik')
            ->select('pembayaran.*', 'pelanggan.nama_pelanggan')
            ->get();

    return view('crud.index', [
        'title' => 'Pembayaran',
        'route' => 'pembayaran',
        'primaryKey' => 'id_pembayaran', 
        // BAGIAN INI WAJIB ADA AGAR TIDAK ERROR 500
        'headers' => ['Nama Pelanggan', 'Tanggal Pembayaran', 'Jumlah Sewa', 'Payment', 'Dompet Digital'],
        'fields'  => ['nama_pelanggan', 'tgl_pembayaran', 'jumlah_sewa', 'pay_online', 'online_method'],
        'data' => $data
    ]);
}

    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('crud.create', $this->config + [
            'pelanggan' => $pelanggan
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'nik'            => 'required|string|max:255',
        'tgl_pembayaran' => 'required|date',
        'jumlah_sewa'    => 'required|numeric',
        'pay_online'     => 'required|string',
        'online_method'  => 'nullable|string',
    ]);

    // Membuat objek baru (Bukan statis)
    $pembayaran = new Pembayaran();
    $pembayaran->nik = $request->nik;
    $pembayaran->tgl_pembayaran = $request->tgl_pembayaran;
    $pembayaran->jumlah_sewa = $request->jumlah_sewa;
    $pembayaran->pay_online = $request->pay_online;
    $pembayaran->online_method = $request->online_method;
    
    // Simpan ke database
    $pembayaran->save();

    return redirect()
        ->route('pembayaran.index')
        ->with('success', 'Data pembayaran berhasil disimpan');
}

    public function edit($id)
{
    // Cari data pembayaran
    $pembayaran = Pembayaran::where('id_pembayaran', $id)->firstOrFail();
    
    // Ambil data pelanggan untuk dropdown jika diperlukan
    $pelanggan = Pelanggan::all();
    
    return view('crud.edit', [
        'title'      => 'Pembayaran',
        'route'      => 'pembayaran',
        'primaryKey' => 'id_pembayaran', // ID Pembayaran akan disembunyikan
        'fields'     => ['id_pembayaran', 'nik', 'tgl_pembayaran', 'jumlah_sewa', 'pay_online', 'online_method'],
        'item'       => $pembayaran,
        'pelanggan'  => $pelanggan // Dikirim agar tidak error @isset di blade
    ]);
}

    public function update(Request $request, $id)
{
    // 1. Validasi data (tanpa mewajibkan online_method jika Cash)
    $request->validate([
        'tgl_pembayaran' => 'required|date',
        'jumlah_sewa'    => 'required|numeric',
        'pay_online'     => 'required',
    ]);

    // 2. Cari data pembayaran berdasarkan ID
    $pembayaran = Pembayaran::findOrFail($id);

    // 3. Ambil semua data dari input form
    $data = $request->all();

    // LOGIKA PENTING: Jika metode pembayaran adalah 'Cash', 
    // pastikan 'online_method' dikosongkan sebelum disimpan ke database.
    if ($request->pay_online === 'Cash') {
        $data['online_method'] = null;
    }

    // 4. Update data ke database
    $pembayaran->update($data);

    return redirect()->route('pembayaran.index')
        ->with('success', 'Data pembayaran berhasil diperbarui');
}

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus');
    }
}