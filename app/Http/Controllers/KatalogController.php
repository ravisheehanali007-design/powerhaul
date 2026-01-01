<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{   
    /**
     * Menampilkan daftar katalog alat berat
     */
    public function index()
    {
        $mobil = DB::table('alatberat')->get();
        return view('user.detail_mobil', [
            'mobil' => $mobil,
            'cars'  => $this->getStaticData() // Menjaga konsistensi data layout jika diperlukan
        ]);
    }

    /**
     * Menampilkan halaman detail satu mobil/alat berat
     * File view: resources/views/user/detail_mobil.blade.php
     */
    // File: app/Http/Controllers/KatalogController.php

public function show($id) 
{
    // Search the static array for the truck with the matching ID
    $allCars = $this->getStaticData();
    $mobil = collect($allCars)->where('id_truk', $id)->first();

    // Convert to object so your Blade syntax ($mobil->nama_truk) still works
    $mobil = (object) $mobil;

    if (!isset($mobil->id_truk)) {
        abort(404, 'Truck not found in static data');
    }

    return view('user.detail_mobil', compact('mobil'));
}

private function getStaticData()
{
    return [
        [
            'id_truk' => 1,
            'nama_truk' => 'Mitsubishi Fuso Canter',
            'tahun' => '2022',
            'harga' => 300000,
            'tipe_truk' => 'Fuso',
            'status' => 'tersedia',
            'foto' => 'car1.png',
            'tipe_bak' => 'Bak Besi',
            'ext_color' => 'White',
            'int_color' => 'Grey',
            'stok' => 4,
            'kapasitas' => '8.250 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => true,
            'gps' => true,
            'plat_nomor' => 'B 1234 CDX',
            'desc' => 'Mitsubishi Fuso Canter adalah truk ringan yang dirancang untuk kebutuhan angkut barang dengan efisiensi,
                daya tahan, dan biaya operasional rendah. Cocok untuk logistik, konstruksi, dan distribusi komersial.'
        ],
        [
            'id_truk' => 2,
            'nama_truk' => 'Mitsubishi Fighter X',
            'tahun' => '2021',
            'harga' => 300000,
            'tipe_truk' => 'Fuso',
    "status" => "tidak tersedia",
            'foto' => 'car2.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'Yellow',
            'int_color' => 'Black',
            'stok' => 0,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => false,
            'gps' => true,
            'plat_nomor' => 'B 5678 XYZ',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 3,
            'nama_truk' => 'Hino Dutro',
            'tahun' => '2023',
            'harga' => 300000,
            'tipe_truk' => 'CDE/CDD',
    "status" => "tersedia",
            'foto' => 'car3.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'Green',
            'int_color' => 'Black',
            'stok' => 2,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => false,
            'gps' => true,
            'plat_nomor' => 'B 7137 ABC',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 4,
            'nama_truk' => 'Hino Ranger',
            'tahun' => '2022',
            'harga' => 300000,
            'tipe_truk' => 'Tronton',
    "status" => "tersedia",
            'foto' => 'car4.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'Green',
            'int_color' => 'Black',
            'stok' => 1,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => true,
            'gps' => false,
            'plat_nomor' => 'B 7631 BAD',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 5,
            'nama_truk' => 'Isuzu Elf',
            'tahun' => '2020',
            'harga' => 300000,
            'tipe_truk' => 'CDE/CDD',
    "status" => "tersedia",
            'foto' => 'car5.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'White',
            'int_color' => 'Grey',
            'stok' => 4,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => true,
            'gps' => true,
            'plat_nomor' => 'B 9132 CAD',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 6,
            'nama_truk' => 'Isuzu Traga',
            'tahun' => '2023',
            'harga' => 300000,
            'tipe_truk' => 'Pick Up',
    "status" => "tidak tersedia",
            'foto' => 'car6.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'White',
            'int_color' => 'Grey',
            'stok' => 0,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => false,
            'gps' => true,
            'plat_nomor' => 'B 3456 DAF',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 7,
            'nama_truk' => 'Isuzu Giga',
            'tahun' => '2019',
            'harga' => 300000,
            'tipe_truk' => 'Trailer',
    "status" => "tersedia",
            'foto' => 'car7.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'White',
            'int_color' => 'Black',
            'stok' => 3,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => false,
            'gps' => true,
            'plat_nomor' => 'B 6789 EGH',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ]
        ,[
            'id_truk' => 8,
            'nama_truk' => 'UD Trucks Quester',
            'tahun' => '2021',
            'harga' => 300000,
            'tipe_truk' => 'Trailer',
    "status" => "tersedia",
            'foto' => 'car8.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'Blue',
            'int_color' => 'Black',
            'stok' => 3,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => true,
            'gps' => true,
            'plat_nomor' => 'B 8901 HIJ',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 9,
            'nama_truk' => 'Daihatsu Gran Max PU',
            'tahun' => '2023',
            'harga' => 300000,
            'tipe_truk' => 'Pick Up',
    "status" => "tersedia",
            'foto' => 'car9.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'White',
            'int_color' => 'Black',
            'stok' => 1,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => false,
            'gps' => true,
            'plat_nomor' => 'B 2345 KLM',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 10,
            'nama_truk' => 'FAW FB 240 CG',
            'tahun' => '2023',
            'harga' => 300000,
            'tipe_truk' => 'Wingbox',
    "status" => "tidak tersedia",
            'foto' => 'car10.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'White',
            'int_color' => 'Grey',
            'stok' => 0,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => true,
            'gps' => true,
            'plat_nomor' => 'B 4567 NOP',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 11,
            'nama_truk' => 'Isuzu FRR 90Q',
            'tahun' => '2023',
            'harga' => 300000,
            'tipe_truk' => 'Wingbox',
    "status" => "tersedia",
            'foto' => 'car11.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'White',
            'int_color' => 'Grey',
            'stok' => 2,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => true,
            'gps' => true,
            'plat_nomor' => 'B 6789 QRS',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ],
        [
            'id_truk' => 12,
            'nama_truk' => 'Mitsubishi Fuso Fighter',
            'tahun' => '2023',
            'harga' => 300000,
            'tipe_truk' => 'Tronton',
    "status" => "tersedia",
            'foto' => 'car12.png',
            'tipe_bak' => 'Dump Truck',
            'ext_color' => 'Yellow',
            'int_color' => 'Black',
            'stok' => 2,
            'kapasitas' => '26.000 kg',
            'bahan_bakar' => 'Diesel',
            'ac' => false,
            'gps' => true,
            'plat_nomor' => 'B 8901 TUV',
            'desc' => 'Mitsubishi Fuso Fighter X adalah truk medium‑duty yang dirancang untuk transportasi barang dan logistik dengan kapasitas tinggi dan performa handal. Ditenagai mesin diesel bertenaga besar, Fighter X menawarkan kombinasi efisiensi bahan bakar dan daya angkut optimal, sehingga cocok untuk distribusi jarak menengah hingga jauh'
        ]
        
    ];
}
}