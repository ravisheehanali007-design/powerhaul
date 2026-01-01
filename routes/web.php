<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StokAlatBeratController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DetailPenyewaanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () { 
    return view('home'); 
})->name('home');

// --- RUTE GUEST (BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
});

// --- RUTE AUTH (SUDAH LOGIN) ---
Route::middleware('auth')->group(function () {
    
    // RUTE ADMIN (Prefix /admin)
    Route::prefix('admin')->group(function () {
        
        // 1. RUTE KHUSUS DETAIL PENYEWAAN (WAJIB DI ATAS RESOURCE)
        // Fitur Cetak
        Route::get('detailpenyewaan/{id}/print', [DetailPenyewaanController::class, 'print'])->name('detailpenyewaan.print');
        
        // Fitur Rincian Item: Tambah (Create & Store)
        Route::get('detailpenyewaan/{id}/create-item', [DetailPenyewaanController::class, 'createItem'])->name('detailpenyewaan.create_item');
        Route::post('detailpenyewaan/store-item', [DetailPenyewaanController::class, 'storeItem'])->name('detailpenyewaan.store_item');
        
        // Fitur Rincian Item: Edit (Edit, Update, & Destroy)
        // Nama fungsi disesuaikan persis dengan Controller Anda (snake_case)
        Route::get('detailpenyewaan/{id}/edit-item', [DetailPenyewaanController::class, 'edit_item'])->name('detailpenyewaan.edit_item');
        Route::put('detailpenyewaan/{id}/update-item', [DetailPenyewaanController::class, 'update_item'])->name('detailpenyewaan.update_item');
        Route::delete('detailpenyewaan/{id}/destroy-item', [DetailPenyewaanController::class, 'destroy_item'])->name('detailpenyewaan.destroy_item');

        // 2. RUTE RESOURCE STANDAR
        Route::resource('detailpenyewaan', DetailPenyewaanController::class);
        Route::resource('stokalatberat', StokAlatBeratController::class);
        Route::resource('pelanggan', PelangganController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::resource('invoice', InvoiceController::class);
        
        // Dashboard Admin
        Route::get('/dashboard-admin', function () {
            return view('dashboard.dashboard_admin');
        })->name('dashboard.admin');
    });
    

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/user/detail/{id}', [KatalogController::class, 'show'])->name('user.detail');

Route::match(['get', 'post'], '/checkout', [BookingController::class, 'checkout'])
    ->name('user.checkout');
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
Route::post('/place-order', [BookingController::class, 'placeOrder'])
    ->name('user.place_order');

    Route::get('/invoice/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
Route::get('/checkout', [BookingController::class, 'checkout'])->name('user.checkout');
Route::get('/order-success/{id}', [App\Http\Controllers\BookingController::class, 'showSuccess'])->name('user.order_success');
    Route::post('/store-booking', [App\Http\Controllers\BookingController::class, 'store'])->name('user.store_booking');
    Route::get('/{route}/{id}/print', [CrudController::class, 'print'])
    ->name('crud.print');
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});