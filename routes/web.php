<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\KullaniciController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.post');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::post('/giris', [KullaniciController::class, 'girisYap'])->name('giris')->middleware('guest');
Route::post('/kayit', [KullaniciController::class, 'kayitOl'])->name('kayit')->middleware('guest');
Route::post('/cikis', [KullaniciController::class, 'cikisYap'])->name('cikis')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [KullaniciController::class, 'profilSayfasi'])->name('profil');
    Route::get('/profil/siparisler', [KullaniciController::class, 'profilSayfasi'])->name('profil.siparisler');
    Route::get('/profil/favoriler', [KullaniciController::class, 'profilSayfasi'])->name('profil.favoriler');

    // Hesap Ayarları
    Route::get('/profil/ayarlar', [KullaniciController::class, 'ayarlarSayfasi'])->name('profil.ayarlar');
    Route::post('/profil/ayarlar/bilgiler', [KullaniciController::class, 'bilgileriGuncelle'])->name('profil.bilgiler.guncelle');
    Route::post('/profil/ayarlar/sifre', [KullaniciController::class, 'sifreDegistir'])->name('profil.sifre.degistir');
});
