<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Tampilkan halaman detail berdasarkan ID
     * Tambahkan fungsi ini untuk menangani tampilan detail_mobil.blade.php
     */
    public function showDetail($id)
    {
        // Gunakan ->first() supaya data berbentuk Object tunggal (bukan Collection/Array)
        $mobil = DB::table('alatberat')
            ->where('id_truk', $id)
            ->first();

        // Jika data tidak ditemukan di database, tampilkan error 404
        if (!$mobil) {
            abort(404);
        }

        // Kirim data ke view user/detail_mobil
        return view('user.detail_mobil', compact('mobil'));
    }

    /**
     * TAHAP 1: Simpan data awal dari Detail Mobil
     */
    public function store(Request $request)
{
    // 1. Validasi Data
    $request->validate([
        'id_truk'     => 'required',
        'pick_up'     => 'required|date',
        'return_date' => 'required|date',
        'total'       => 'required', 
    ]);

    // 2. Pembersihan Total
    // Mengubah "Rp 740.000" menjadi 740000 agar masuk ke kolom INT
    $totalClean = (int) preg_replace('/[^0-9]/', '', $request->total);

    // 3. Insert ke Database
    // insertGetId akan mengambil ID baru (misal 28, 29, dst)
    $id_invoice = DB::table('invoice')->insertGetId([
        'id_truk'     => $request->id_truk,
        'pick_up'     => $request->pick_up,
        'return_date' => $request->return_date,
        'qty'         => $request->qty ?? 1,
        'total'       => (int) preg_replace('/[^0-9]/', '', $request->total),
        'created_at'  => now(),
    ]);

    // REDIRECT INI yang akan menghasilkan URL ?order_id=...
    return redirect()->route('user.checkout', ['order_id' => $id_invoice]);
}

    /**
     * TAHAP 2: Tampilkan halaman checkout (TANPA INSERT)
     */
    public function checkout(Request $request)
{
    // Cek apakah ada order_id, jika tidak ada ambil yang terbaru agar halaman tidak kosong
    $orderId = $request->order_id ?? DB::table('invoice')->latest('id_invoice')->value('id_invoice');

    $order = DB::table('invoice')
        ->where('id_invoice', $orderId)
        ->first();

    // JANGAN redirect ke user.katalog karena filenya tidak ada
    if (!$order) {
        return "Gagal memuat data: Pesanan tidak ditemukan di database.";
    }

    $truk = DB::table('alatberat')
        ->where('id_truk', $order->id_truk)
        ->first();

    // Pastikan nama view sesuai dengan lokasi file Anda (misal: checkout.blade.php)
    return view('user.checkout', [
        'order_id'    => $order->id_invoice,
        'id_truk'     => $order->id_truk,
        'car_name'    => $truk->nama_truk ?? 'Unit Powerhaul',
        'qty'         => $order->qty ?? 1,
        'pick_up'     => $order->pick_up,
        'return_date' => $order->return_date,
        'car_price'   => $order->total,
    ]);
}

    /**
     * TAHAP 3: Finalisasi Order
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'nik'      => 'required',
            'phone'    => 'required',
            'fname'    => 'required|string|max:255',
            'email'    => 'required|email',
        ]);

        DB::table('invoice')
    ->where('id_invoice', $request->order_id)
    ->update([
        'nik'           => $request->nik,
        'fname'         => $request->fname,
        'country'       => $request->country,
        'city'          => $request->city,
        'streetaddress' => $request->streetaddress,
        'kodepos'       => $request->kodepos,
        'phone'         => $request->phone,
        'email'         => $request->email,
        'notes'         => $request->notes,
        'total'         => $request->total,
        'qty'           => $request->qty,
        // Update status flag (1 atau 0)
        'pay_cash'      => $request->payment_method === 'cash' ? 1 : 0,
        'pay_online'    => $request->payment_method === 'online' ? 1 : 0,
        // Menambahkan teks metode ke kolom online_method sesuai tabel Anda
        'online_method' => $request->payment_method === 'cash' ? 'Cash Payment' : 'Online Payment',
        'updated_at'    => now(),
    ]);
        return redirect()->route('user.order_success', [
            'id' => $request->order_id
        ]);
    }

    /**
     * TAHAP 4: Halaman sukses
     */
    public function showSuccess($id)
    {
        $order = DB::table('invoice as i')
            ->leftJoin('alatberat as a', 'i.id_truk', '=', 'a.id_truk')
            ->where('i.id_invoice', $id)
            ->first();

        return view('user.order_success', compact('order'));
    }
}