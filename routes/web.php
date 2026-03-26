<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UrunController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.post');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


    Route::get('/kategoriler', [KategoriController::class, 'index'])->name('admin.kategoriler.index');

    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    Route::post('/kategoriler', [KategoriController::class, 'store'])->name('admin.kategoriler.store');

    // ÜRÜN ROTALARI
    Route::get('/urunler', [UrunController::class, 'index'])->name('admin.urunler.index');
    Route::get('/urunler/ekle', [UrunController::class, 'create'])->name('admin.urunler.create');
    Route::post('/urunler', [UrunController::class, 'store'])->name('admin.urunler.store');
    Route::get('/urunler/{id}/varyasyonlar', [UrunController::class, 'varyasyonlar'])->name('admin.urunler.varyasyonlar');
 
    Route::post('/urunler/{id}/varyasyonlar', [UrunController::class, 'varyasyonKaydet'])->name('admin.urunler.varyasyonKaydet');
    Route::delete('/urunler/varyasyon/{id}', [UrunController::class, 'varyasyonSil'])->name('admin.urunler.varyasyonSil');
});