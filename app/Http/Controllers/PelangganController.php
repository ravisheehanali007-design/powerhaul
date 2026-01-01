<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    protected $config = [
        'title'  => 'Pelanggan',
        'route'  => 'pelanggan',
        'fields' => [
            'nik',
            'nama_pelanggan',
            'country',
            'city',
            'phone',
            'email',
            'address'
        ],
    ];

    // ===============================
    // INDEX
    // ===============================
    public function index() {
    return view('crud.index', [
        'title' => 'Pelanggan',
        'route' => 'pelanggan',
        'primaryKey' => 'nik', // PK Pelanggan adalah NIK
        'headers' => ['NIK', 'Nama Pelanggan','Country','City', 'Nomor HP', 'Email', 'Address'],
        'fields' => ['nik', 'nama_pelanggan', 'country', 'city', 'phone', 'email', 'address'],
        'data' => Pelanggan::all()
    ]);
}


    // ===============================
    // CREATE
    // ===============================
    public function create()
    {
        return view('crud.create', $this->config);
    }

    // ===============================
    // STORE
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nik'            => 'required|unique:pelanggan,nik',
            'nama_pelanggan' => 'required',
            'email'          => 'required|email',
            'phone'          => 'required',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar!',
        ]);

        Pelanggan::create($request->all());

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil disimpan');
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
{
    $pelanggan = Pelanggan::where('nik', $id)->firstOrFail();
    
    return view('crud.edit', [
        'title'      => 'Pelanggan',
        'route'      => 'pelanggan',
        'primaryKey' => 'nik', // NAMA INI HARUS SAMA DENGAN ISI DI ARRAY $fields
        'fields'     => ['nik', 'nama_pelanggan', 'country', 'city', 'phone', 'email', 'address'],
        'item'       => $pelanggan
    ]);
}

    // ===============================
    // UPDATE
    // ===============================
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'email'          => 'required|email',
            'phone'          => 'required',
        ]);

        $pelanggan->update($request->all());

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }

    // ===============================
    // DESTROY
    // ===============================
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil dihapus');
    }
}
