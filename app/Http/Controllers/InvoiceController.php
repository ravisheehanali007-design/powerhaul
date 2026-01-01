<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
{
    // Menggunakan Eloquent Model lebih aman
    $data = DB::table('invoice')
            ->leftJoin('alatberat', 'invoice.id_truk', '=', 'alatberat.id_truk')
            ->select('invoice.*', 'alatberat.nama_truk') // Mengambil semua kolom invoice + nama_truk dari alatberat
            ->orderBy('invoice.created_at', 'desc')
            ->get();

        $title = "Invoice";
        $route = "invoice";
        $primaryKey = "id_invoice";

        $headers = ['ID Invoice', 'Nama','NIK', 'Alat Berat','Pick Up','Return', 'Country', 'Email', 'Nomor HP', 'Qty', 'Total', 'Payment',  'Tanggal Dibuat'];

        // 'nama_truk' sekarang tersedia berkat join di atas
        $fields = ['id_invoice', 'fname', 'nik', 'nama_truk','pick_up', 'return_date', 'country', 'email', 'phone', 'qty', 'total', 'online_method',  'created_at'];

        return view('crud.index', compact('title', 'data', 'route', 'headers', 'fields', 'primaryKey'));
    }

    // Tambahkan method lain agar resource rute tidak error
    public function create() 
{ 
    $title = "Invoice";
    $route = "invoice";
    $alatberat = DB::table('alatberat')->get(); 
    // Ambil data pelanggan agar bisa dipilih di dropdown
    $pelanggan = DB::table('pelanggan')->get(); 

    $fields = ['fname', 'id_truk', 'nik','pick_up', 'return_date', 'country', 'email', 'phone', 'qty', 'total', 'online_method'];

    return view('crud.create', compact('title', 'route', 'alatberat', 'pelanggan', 'fields')); 
}

    public function store(Request $request) 
{ 
    // 1. Tambahkan field yang mungkin terlewat di validasi
    $request->validate([
        'fname'   => 'required|string|max:255',
        'id_truk' => 'required',
        'email'   => 'required|email',
        'phone'   => 'required',
        'qty'     => 'required|numeric',
        'total'   => 'required|numeric',
        // Tambahkan ini jika di database bersifat NOT NULL
        'nik'     => 'nullable', 
        'pick_up' => 'nullable|date',
        'return_date' => 'nullable|date',
    ]);

    // 2. Simpan ke Database
    DB::table('invoice')->insert([
        'fname'         => $request->fname,
        'id_truk'       => $request->id_truk,
        'country'       => $request->country,
        'email'         => $request->email,
        'phone'         => $request->phone,
        'qty'           => $request->qty,
        'total'         => $request->total,
        'online_method' => $request->online_method ?? 'Manual',
        'nik'           => $request->nik ?? '-', // Mengisi default jika kosong
        'pick_up'       => $request->pick_up ?? now(),
        'return_date'   => $request->return_date ?? now(),
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);

    return redirect()->route('invoice.index')->with('success', 'Data Invoice berhasil ditambahkan!');
}
public function edit($id)
{
    $title = "Invoice";
    $route = "invoice";
    $primaryKey = "id_invoice"; // TAMBAHKAN BARIS INI

    // Ambil data invoice berdasarkan id_invoice
    $item = DB::table('invoice')->where('id_invoice', $id)->first();

    // Pastikan data item ditemukan
    if (!$item) {
        return redirect()->route('invoice.index')->with('error', 'Data tidak ditemukan');
    }

    $alatberat = DB::table('alatberat')->get();
    $pelanggan = DB::table('pelanggan')->get();

    $fields = [
        'fname', 'id_truk', 'nik', 'pick_up', 'return_date', 
        'country', 'email', 'phone', 'qty', 'total', 'online_method'
    ];

    // Kirim $primaryKey ke View
    return view('crud.edit', compact('title', 'route', 'item', 'alatberat', 'pelanggan', 'fields', 'primaryKey'));
}

public function update(Request $request, $id)
{
    // 1. Validasi Data
    $request->validate([
        'fname'   => 'required|string|max:255',
        'id_truk' => 'required',
        'email'   => 'required|email',
        'phone'   => 'required',
        'qty'     => 'required|numeric',
        'total'   => 'required|numeric',
        'nik'     => 'required', // NIK diwajibkan karena FK
        'pick_up' => 'required|date',
    ]);

    // 2. Proses Update ke Database
    DB::table('invoice')->where('id_invoice', $id)->update([
        'fname'         => $request->fname,
        'id_truk'       => $request->id_truk,
        'country'       => $request->country,
        'email'         => $request->email,
        'phone'         => $request->phone,
        'qty'           => $request->qty,
        'total'         => $request->total,
        'online_method' => $request->online_method,
        'nik'           => $request->nik,
        'pick_up'       => $request->pick_up,
        'return_date'   => $request->return_date,
        'updated_at'    => now(),
    ]);

    return redirect()->route('invoice.index')->with('success', 'Data Invoice berhasil diperbarui!');
}
public function destroy($id)
{
    // Menghapus data invoice berdasarkan id_invoice
    $deleted = DB::table('invoice')->where('id_invoice', $id)->delete();

    if ($deleted) {
        return redirect()->route('invoice.index')->with('success', 'Data Invoice berhasil dihapus!');
    }

    return redirect()->route('invoice.index')->with('error', 'Gagal menghapus data atau data tidak ditemukan.');
}
}