<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Kategori\Kategori;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\KartuStock\KartuStock;
use App\Http\Livewire\Laporan\BarangMasuk as LaporanBarangMasuk;
use App\Http\Livewire\MasterData\DaftarCustomer;
use App\Http\Livewire\MasterData\DaftarSupplier;
use App\Http\Livewire\MasterData\DataBarang;
use App\Http\Livewire\MasterData\Satuan;
use App\Http\Livewire\Persediaan\BarangKeluar;
use App\Http\Livewire\Persediaan\BarangMasuk;
use App\Http\Livewire\Persediaan\BarangOpname;
use App\Http\Livewire\Persediaan\SaldoAwalBarang;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store']);

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('laporan-excel/saldo-awal/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanSaldoAwalItem::class, 'exportExcel'])->name('laporan-excel.saldo-awal');
    Route::get('laporan-pdf/saldo-awal/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanSaldoAwalItem::class, 'exportPDF'])->name('laporan-pdf.saldo-awal');

    Route::get('laporan-excel/barang-masuk/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanBarangMasuk::class, 'exportExcel'])->name('laporan-excel.barang-masuk');
    Route::get('laporan-pdf/barang-masuk/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanBarangMasuk::class, 'exportPDF'])->name('laporan-pdf.barang-masuk');

    Route::get('laporan-excel/barang-keluar/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanBarangKeluar::class, 'exportExcel'])->name('laporan-excel.barang-keluar');
    Route::get('laporan-pdf/barang-keluar/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanBarangKeluar::class, 'exportPDF'])->name('laporan-pdf.barang-keluar');

    Route::get('laporan-excel/barang-opname/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanBarangKeluar::class, 'exportExcel'])->name('laporan-excel.barang-opname');
    Route::get('laporan-pdf/barang-opname/{id_user}/{id_barang}/{dari_tanggal}/{sampai_tanggal}', [LaporanBarangKeluar::class, 'exportPDF'])->name('laporan-pdf.barang-opname');

});

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::get('kategori', Kategori::class)->name('kategori');
    Route::get('satuan', Satuan::class)->name('satuan');
    Route::get('daftar-barang',DataBarang::class)->name('daftar-barang');
    Route::get('daftar-supplier', DaftarSupplier::class)->name('daftar-supplier');
    Route::get('daftar-customer', DaftarCustomer::class)->name('daftar-customer');

    Route::get('saldo-awal-barang', SaldoAwalBarang::class)->name('saldo-awal-barang');
    Route::get('stok-masuk', BarangMasuk::class)->name('barang-masuk');
    Route::get('stok-keluar', BarangKeluar::class)->name('barang-keluar');
    Route::get('stok-opname', BarangOpname::class)->name('stok-opname');

    Route::get('kartu-stock', KartuStock::class)->name('kartu-stock');
});

Route::group(['middleware' => ['auth', 'role:user']], function() {
});

Route::group(['middleware' => ['auth', 'role:developer']], function() {
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
