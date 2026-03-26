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
    
    // ── DASHBOARD VE GENEL ROTALAR ──────────────────────────
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // ── KATEGORİ ROTALARI ───────────────────────────────────
    Route::get('/kategoriler', [KategoriController::class, 'index'])->name('admin.kategoriler.index');
    Route::post('/kategoriler', [KategoriController::class, 'store'])->name('admin.kategoriler.store');

    // ── ÜRÜN ROTALARI ───────────────────────────────────────
    
    // Resource rotası: index, create, store, edit, update, destroy işlemlerini otomatik kapsar.
    // İsimlendirmenin "admin.urunler.xxx" şeklinde kalması için ->names('admin.urunler') eklendi.
    Route::resource('urunler', UrunController::class)
        ->parameters(['urunler' => 'id'])
        ->names('admin.urunler')
        ->except(['show']); // Ürün detay sayfası frontend'de, admin'de gerek yok

    // Görsel silme (AJAX — DELETE isteği, JSON döner) -- EKSİKTİ, EKLENDİ
    Route::delete('urunler/gorsel/{gorselId}', [UrunController::class, 'gorselSil'])
        ->name('admin.urunler.gorselSil');

    // Varyasyon yönetim sayfası
    Route::get('urunler/{id}/varyasyonlar', [UrunController::class, 'varyasyonlar'])
        ->name('admin.urunler.varyasyonlar');

    // Yeni varyasyon kaydetme
    Route::post('urunler/{id}/varyasyonlar', [UrunController::class, 'varyasyonKaydet'])
        ->name('admin.urunler.varyasyonKaydet');

    // Varyasyon silme
    Route::delete('urunler/varyasyon/{id}', [UrunController::class, 'varyasyonSil'])
        ->name('admin.urunler.varyasyonSil');
        
});