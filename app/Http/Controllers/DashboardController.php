<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // 1. TAMBAHKAN parameter Request $request di sini
    public function index(Request $request) 
    {
        $categories = [
            ['title' => 'Pick Up',  'image' => 'images/truk1.png', 'disabled' => false],
            ['title' => 'CDE/CDD',  'image' => 'images/truk2.png', 'disabled' => false],
            ['title' => 'Fuso',     'image' => 'images/truk3.png', 'disabled' => false],
            ['title' => 'Tronton',  'image' => 'images/truk4.png', 'disabled' => false],
            ['title' => 'Wingbox',  'image' => 'images/truk5.png', 'disabled' => false],
            ['title' => 'Trailer',  'image' => 'images/truk6.png', 'disabled' => false],
        ];

        // 2. GANTI nama variabel menjadi $allCars agar sesuai dengan logika filter di bawah
        $allCars = [
            [
                'id_truk' => 1,
                "title" => "Mitsubishi Fuso Canter",
                "year" => "2022",
                "photo" => "images/car1.png",
                "type" => "Fuso",
                "file" => "car1.php",
                "desc" => "Truk ringan tangguh untuk distribusi harian dengan konsumsi bahan bakar efisien."
            ],
            [
                'id_truk' => 2,
                "title" => "Mitsubishi Fighter X",
                "year" => "2021",
                "photo" => "images/car2.png",
                "type" => "Fuso",
                "file" => "car2.php",
                "desc" => "Cocok untuk angkutan jarak jauh yang membutuhkan performa mesin kuat."
            ],
            [
                'id_truk' => 3,
                "title" => "Hino Dutro",
                "year" => "2023",
                "photo" => "images/car3.png",
                "type" => "CDE/CDD",
                "file" => "car3.php",
                "desc" => "Dirancang untuk aktivitas logistik perkotaan dengan manuver yang sangat fleksibel."
            ],
            [
                'id_truk' => 4,
                "title" => "Hino Ranger",
                "year" => "2022",
                "photo" => "images/car4.png",
                "type" => "Tronton",
                "file" => "car4.php",
                "desc" => "Memiliki kapasitas angkut besar, ideal untuk proyek konstruksi dan muatan berat."
            ],
            [
                'id_truk' => 5,
                "title" => "Isuzu Elf",
                "year" => "2020",
                "photo" => "images/car5.png",
                "type" => "CDE/CDD",
                "file" => "car5.php",
                "desc" => "Ringan, kuat, and irit bahan bakar. Cocok untuk kebutuhan ekspedisi skala kecil."
            ],
            [
                'id_truk' => 6,
                "title" => "Isuzu Traga",
                "year" => "2023",
                "photo" => "images/car6.png",
                "type" => "Pick Up",
                "file" => "car6.php",
                "desc" => "Pick up serbaguna dengan bak luas, ideal untuk pengiriman barang harian."
            ],
            [
                'id_truk' => 7,
                "title" => "Isuzu Giga",
                "year" => "2019",
                "photo" => "images/car7.png",
                "type" => "Trailer",
                "file" => "car7.php",
                "desc" => "Cocok untuk menarik trailer berat dengan daya tahan mesin yang sudah terbukti."
            ],
            [
                'id_truk' => 8,
                "title" => "UD Trucks Quester",
                "year" => "2021",
                "photo" => "images/car8.png",
                "type" => "Trailer",
                "file" => "car8.php",
                "desc" => "Truk modern dengan teknologi optimal untuk efisiensi dan kenyamanan sopir."
            ],
            [
                'id_truk' => 9,
                "title" => "Daihatsu Gran Max PU",
                "year" => "2023",
                "photo" => "images/car9.png",
                "type" => "Pick Up",
                "file" => "car9.php",
                "desc" => "Kendaraan lincah dan hemat BBM, cocok untuk UMKM dan jasa distribusi ringan."
            ],
            [
                'id_truk' => 10,
                "title" => "FAW FB 240 CG",
                "year" => "2023",
                "photo" => "images/car10.png",
                "type" => "Wingbox",
                "file" => "car10.php",
                "desc" => "Wingbox besar untuk barang sensitif cuaca dengan akses muatan yang lebih mudah."
            ],
            [
                'id_truk' => 11,
                "title" => "Isuzu FRR 90Q",
                "year" => "2023",
                "photo" => "images/car11.png",
                "type" => "Wingbox",
                "file" => "car11.php",
                "desc" => "Efisiensi tinggi dan ruang kargo luas, ideal untuk pengiriman logistik modern."
            ],
            [
                'id_truk' => 12,
                "title" => "Mitsubishi Fuso Fighter",
                "year" => "2023",
                "photo" => "images/car12.png",
                "type" => "Tronton",
                "file" => "car12.php",
                "desc" => "Mesin kuat untuk angkutan berat dengan stabilitas tinggi di berbagai medan."
            ]
        ];

        // Ambil parameter kategori dari URL (?category=...)
        $selectedCategory = $request->query('category');
        
        if ($selectedCategory) {
            // Filter koleksi berdasarkan 'type'
            $cars = collect($allCars)->where('type', $selectedCategory)->all();
        } else {
            // Jika tidak ada filter, tampilkan semua mobil
            $cars = $allCars;
        }

        return view('dashboard.dashboard', compact('categories', 'cars'));
    }
}