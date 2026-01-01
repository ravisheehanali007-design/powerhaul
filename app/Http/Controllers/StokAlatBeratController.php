<?php

namespace App\Http\Controllers;

use App\Models\StokAlatBerat;
use Illuminate\Http\Request;

class StokAlatBeratController extends Controller
{
    public function index() {
    return view('crud.index', [
        'title' => 'Stok Alat Berat',
        'route' => 'stokalatberat',
        'primaryKey' => 'id_truk', // Sesuaikan dengan PK di database Anda
        'headers' => ['ID Truk', 'Nama Truk', 'Merk', 'Harga','Tahun', 'Status'],
        'fields' => ['id_truk', 'nama_truk', 'merk', 'harga', 'tahun', 'status'],
        'data' => StokAlatBerat::all()
    ]);
}

    public function create()
    {
        return view('crud.create', [
            'title'  => 'Tambah Alat Berat',
            'route'  => 'stokalatberat',
            'fields' => [
                'nama_truk',
                'merk',
                'harga',
                'tahun',
                'status'
            ]
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_truk' => 'required',
        'merk'      => 'required',
        'harga'     => 'required|numeric',
        'tahun'     => 'required|numeric',
        // Gunakan huruf kecil agar sama dengan value di blade
        'status'    => 'required|in:tersedia,tidak tersedia,disewa',
    ]);

    StokAlatBerat::create($request->all());

    return redirect()
        ->route('stokalatberat.index')
        ->with('success', 'Data berhasil ditambahkan');
}

    public function edit($id)
{
    // Cari data berdasarkan ID-nya
    $stokalatberat = StokAlatBerat::where('id_truk', $id)->firstOrFail();
    
    return view('crud.edit', [
        'title'      => 'Stok Alat Berat',
        'route'      => 'stokalatberat',
        'primaryKey' => 'id_truk', // NIK/ID ini akan disembunyikan di view
        'fields'     => ['id_truk', 'nama_truk', 'merk', 'harga', 'tahun', 'status'],
        'item'       => $stokalatberat
    ]);
}

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_truk' => 'required',
        'merk'      => 'required',
        'harga'     => 'required|numeric',
        'tahun'     => 'required|numeric',
        'status'    => 'required|in:tersedia,tidak tersedia',
    ]);

    $stok = StokAlatBerat::where('id_truk', $id)->firstOrFail();
    $stok->update($request->all());

    return redirect()->route('stokalatberat.index')->with('success', 'Data alat berat berhasil diupdate');
}

    public function destroy(StokAlatBerat $stokalatberat)
    {
        $stokalatberat->delete();

        return redirect()
            ->route('stokalatberat.index')
            ->with('success', 'Data berhasil dihapus');
    }
}