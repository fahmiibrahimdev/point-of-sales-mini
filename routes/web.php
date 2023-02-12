<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Kategori\Kategori;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\MasterData\DaftarCustomer;
use App\Http\Livewire\MasterData\DaftarSupplier;
use App\Http\Livewire\MasterData\DataBarang;
use App\Http\Livewire\MasterData\Satuan;

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
});

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::get('kategori', Kategori::class)->name('kategori');
    Route::get('satuan', Satuan::class)->name('satuan');
    Route::get('daftar-barang',DataBarang::class)->name('daftar-barang');
    Route::get('daftar-supplier', DaftarSupplier::class)->name('daftar-supplier');
    Route::get('daftar-customer', DaftarCustomer::class)->name('daftar-customer');
});

Route::group(['middleware' => ['auth', 'role:user']], function() {
});

Route::group(['middleware' => ['auth', 'role:developer']], function() {
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
