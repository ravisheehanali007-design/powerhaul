<?php

namespace App\Http\Controllers;

use App\Models\DetailPenyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailPenyewaanController extends Controller
{
    protected $model = DetailPenyewaan::class;
    protected $config = [
        'model' => \App\Models\DetailPenyewaan::class,
    ];
    public function index()
    {
        $data = DB::table('detailpenyewaan')
                ->join('alatberat', 'detailpenyewaan.id_truk', '=', 'alatberat.id_truk')
                ->join('pembayaran', 'detailpenyewaan.id_pembayaran', '=', 'pembayaran.id_pembayaran')
                ->join('pelanggan', 'detailpenyewaan.nik', '=', 'pelanggan.nik')
                ->select(
                    'detailpenyewaan.*', 
                    'alatberat.nama_truk', 
                    'pembayaran.tgl_pembayaran', 
                    'pelanggan.nama_pelanggan'
                )
                ->get();

        return view('crud.index', [
            'title'      => 'Detail Pemesanan',
            'route'      => 'detailpenyewaan',
            'primaryKey' => 'id_detail',
            'headers'    => ['ID Detail', 'ID Pembayaran', 'Nama Truk', 'Pick UP','Return', 'Total'],
            'fields'     => ['id_detail', 'id_pembayaran', 'nama_truk', 'pick_up','return_date', 'total'],
            'data'       => $data,
            'cars'       => $this->getCars() // WAJIB: Agar layout utama tidak error
        ]);
    }

    public function show($id)
{
    // 1. Ambil data induk nota penyewaan
    $item = DB::table('detailpenyewaan')
        ->join('pelanggan', 'detailpenyewaan.nik', '=', 'pelanggan.nik')
        ->where('detailpenyewaan.id_detail', $id)
        ->select('detailpenyewaan.*', 'pelanggan.nama_pelanggan')
        ->first();

    // 2. Ambil data rincian (Gunakan leftJoin agar data tetap muncul walau ID truk tidak sinkron)
    $rincian = DB::table('rincian_penyewaan')
        ->leftJoin('alatberat', 'rincian_penyewaan.id_truk', '=', 'alatberat.id_truk')
        ->where('rincian_penyewaan.id_detail', $id)
        ->select('rincian_penyewaan.*', 'alatberat.nama_truk')
        ->get();

    // 3. Pastikan HANYA ADA SATU return view dengan semua variabel yang dibutuhkan
    return view('crud.show', [
        'item'    => $item,
        'rincian' => $rincian,
        'route'   => 'detailpenyewaan',
        'title'   => 'Detail Nota ' . $id,
        'fields'  => ['id_detail', 'id_pembayaran', 'nama_pelanggan', 'pick_up', 'return_date'],
        'cars'    => $this->getCars()
    ]);
}

    public function create()
    {
        return view('crud.create', [
            'title'      => 'Detail Pemesanan',
            'route'      => 'detailpenyewaan',
            'fields'     => ['id_detail','id_pembayaran', 'id_truk', 'nik','pick_up','return_date'],
            'alatberat'  => DB::table('alatberat')->get(), 
            'pelanggan'  => DB::table('pelanggan')->get(),
            'cars'       => $this->getCars() // WAJIB
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_detail'     => 'required|unique:detailpenyewaan,id_detail',
            'id_pembayaran' => 'required|numeric|exists:pembayaran,id_pembayaran',
            'id_truk'       => 'required',
            'nik'           => 'required',
            'pick_up'       => 'required',
            'return_date'   => 'required',
        ]);

        try {
            DetailPenyewaan::create($request->all());
            return redirect()->route('detailpenyewaan.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $detail = DetailPenyewaan::where('id_detail', $id)->firstOrFail();
        
        return view('crud.edit', [
            'title'      => 'Edit Detail Pemesanan',
            'route'      => 'detailpenyewaan',
            'primaryKey' => 'id_detail',
            'fields'     => ['id_pembayaran', 'id_truk','pick_up','return_date', 'total'],
            'item'       => $detail,
            'alatberat'  => DB::table('alatberat')->get(),
            'pelanggan'  => DB::table('pelanggan')->get(),
            'cars'       => $this->getCars() // WAJIB
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pembayaran' => 'required|numeric|exists:pembayaran,id_pembayaran',
            'id_truk'       => 'required',
            'pick_up'       => 'required',
            'return_date'   => 'required',
            'total'         => 'required|numeric',
        ]);

        try {
            $detail = DetailPenyewaan::where('id_detail', $id)->firstOrFail();
            $detail->update($request->all());
            return redirect()->route('detailpenyewaan.index')->with('success', 'Detail pemesanan diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DetailPenyewaan::where('id_detail', $id)->delete();
        return redirect()->route('detailpenyewaan.index')->with('success', 'Data berhasil dihapus');
    }

    public function print($id)
{
    // 1. Ambil data induk nota (Gunakan JOIN agar nama pelanggan muncul)
    $invoice = DB::table('detailpenyewaan')
        ->join('pelanggan', 'detailpenyewaan.nik', '=', 'pelanggan.nik')
        ->where('detailpenyewaan.id_detail', $id)
        ->select('detailpenyewaan.*', 'pelanggan.nama_pelanggan')
        ->first();

    if (!$invoice) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // 2. Ambil rincian item alat berat untuk nota ini
    $rincian = DB::table('rincian_penyewaan')
        ->join('alatberat', 'rincian_penyewaan.id_truk', '=', 'alatberat.id_truk')
        ->where('rincian_penyewaan.id_detail', $id)
        ->select('rincian_penyewaan.*', 'alatberat.nama_truk')
        ->get();

    // 3. Kirim ke view dengan nama variabel yang konsisten
    return view('crud.cetak', [
        'invoice' => $invoice,
        'rincian' => $rincian
    ]);
}
    private function getCars()
    {
        return DB::table('alatberat')->get()->map(function ($truck) {
            return [
                'title' => $truck->nama_truk,
                'year'  => '2023',
                'type'  => $truck->merk,
                'photo' => 'images/truk1.png',
                'desc'  => 'PowerHaul Trucks'
            ];
        });
    }
    public function createItem($id)
{
    $item = DB::table('detailpenyewaan')->where('id_detail', $id)->first();
    if (!$item) { abort(404); }

    // AMBIL DATA RINCIAN UNTUK TABEL DI SISI KANAN
    $rincian = DB::table('rincian_penyewaan')
        ->join('alatberat', 'rincian_penyewaan.id_truk', '=', 'alatberat.id_truk')
        ->where('rincian_penyewaan.id_detail', $id)
        ->select('rincian_penyewaan.*', 'alatberat.nama_truk')
        ->get();

    return view('crud.create_item', [
        'title'     => 'Tambah Detail Nota',
        'item'      => $item,
        'rincian'   => $rincian, // Tambahkan ini agar tidak error @forelse
        'alatberat' => DB::table('alatberat')->get(),
        'route'     => 'detailpenyewaan',
        'cars'      => $this->getCars()
    ]);
}
public function storeItem(Request $request)
{
    try {
        // 1. Simpan baris rincian
        DB::table('rincian_penyewaan')->insert([
            'id_detail' => $request->id_detail,
            'id_truk'   => $request->id_truk,
            'banyaknya' => $request->banyaknya,
            'jumlah'    => $request->jumlah, // Nilai dari input hidden 'jumlah'
        ]);

        // 2. UPDATE TOTAL DI TABEL INDUK (SANGAT PENTING)
        // Gunakan where yang tepat sesuai ID Nota
        DB::table('detailpenyewaan')
            ->where('id_detail', $request->id_detail)
            ->increment('total', $request->jumlah);

        return redirect()->route('detailpenyewaan.show', $request->id_detail)
                         ->with('success', 'Item berhasil ditambahkan!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}
public function destroy_item($id_rincian)
{
    $rincian = DB::table('rincian_penyewaan')->where('id_rincian', $id_rincian)->first();
    
    if ($rincian) {
        // Kurangi total harga di nota induk
        DB::table('detailpenyewaan')
            ->where('id_detail', $rincian->id_detail)
            ->decrement('total', $rincian->jumlah);

        DB::table('rincian_penyewaan')->where('id_rincian', $id_rincian)->delete();
        
        return redirect()->back()->with('success', 'Item berhasil dihapus');
    }
    
    return redirect()->back()->with('error', 'Data tidak ditemukan');
}
public function edit_item($id_rincian)
{
    // Mengambil data rincian tunggal yang akan diedit
    $rincian = DB::table('rincian_penyewaan')->where('id_rincian', $id_rincian)->first();
    
    // Mengambil data induk untuk context tampilan
    $itemInduk = DB::table('detailpenyewaan')
        ->leftJoin('pelanggan', 'detailpenyewaan.nik', '=', 'pelanggan.nik')
        ->where('detailpenyewaan.id_detail', $rincian->id_detail)
        ->select('detailpenyewaan.*', 'pelanggan.nama_pelanggan')
        ->first();

    return view('crud.edit_item', [
        'rincian'    => $rincian, // Pastikan nama variabel ini sesuai (rincian)
        'itemInduk'  => $itemInduk,
        'alatberat'  => DB::table('alatberat')->get(),
        'route'      => 'detailpenyewaan'
    ]);
}
public function update_item(Request $request, $id_rincian)
{
    // 1. Validasi input
    $request->validate([
        'banyaknya' => 'required|integer|min:1',
        'jumlah'    => 'required|numeric',
    ]);

    // 2. Ambil data rincian lama sebelum diupdate
    $old = DB::table('rincian_penyewaan')->where('id_rincian', $id_rincian)->first();

    if (!$old) {
        return redirect()->back()->with('error', 'Data rincian tidak ditemukan.');
    }

    // 3. Update data pada tabel rincian_penyewaan
    DB::table('rincian_penyewaan')->where('id_rincian', $id_rincian)->update([
        'banyaknya' => $request->banyaknya,
        'jumlah'    => $request->jumlah,
    ]);

    // 4. Sinkronisasi Total Harga di tabel detailpenyewaan
    // Menghitung selisih antara harga baru dan harga lama
    $selisih = $request->jumlah - $old->jumlah;
    
    DB::table('detailpenyewaan')
        ->where('id_detail', $old->id_detail)
        ->increment('total', $selisih);

    // 5. Perbaikan Redirect: Langsung sebutkan nama route-nya
    return redirect()->route('detailpenyewaan.show', $old->id_detail)
        ->with('success', 'Rincian item berhasil diperbarui.');
}
}