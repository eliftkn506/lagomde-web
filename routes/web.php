<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KullaniciController;
use App\Http\Controllers\SayfaController; // Ön Yüz Sayfaları İçin
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UrunController;
use App\Http\Controllers\Admin\SayfaController as AdminSayfaController; // Admin Sayfaları İçin
use App\Http\Controllers\Admin\AnasayfaBlokController;
use App\Http\Controllers\KategoriSayfaController;
use App\Http\Controllers\UrunDetayController;
use App\Http\Controllers\OzelKutuController;


// ── FRONTEND (ÖN YÜZ) ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dinamik Sayfalar (Biz Kimiz, KVKK vb.)
Route::get('/s/{slug}', [SayfaController::class, 'goster'])->name('sayfa.goster');

// ── KULLANICI İŞLEMLERİ ───────────────────────────────────────
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

// ── ADMİN GİRİŞ ───────────────────────────────────────────────
Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.post');

// ── ADMİN PANELİ ──────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/', function () { return view('admin.dashboard'); })->name('admin.dashboard');

    // Kategoriler
    Route::get('/kategoriler', [KategoriController::class, 'index'])->name('admin.kategoriler.index');
    Route::post('/kategoriler', [KategoriController::class, 'store'])->name('admin.kategoriler.store');
    
    // Kategori Düzenleme, Güncelleme ve Silme Rotaları Eklendi
    Route::get('/kategoriler/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategoriler.edit');
    Route::put('/kategoriler/{id}', [KategoriController::class, 'update'])->name('admin.kategoriler.update');
    Route::delete('/kategoriler/{id}', [KategoriController::class, 'destroy'])->name('admin.kategoriler.destroy');

    // Ürünler
    Route::resource('urunler', UrunController::class)
        ->parameters(['urunler' => 'id'])
        ->names('admin.urunler')
        ->except(['show']);

    Route::delete('urunler/gorsel/{gorselId}', [UrunController::class, 'gorselSil'])->name('admin.urunler.gorselSil');
    Route::get('urunler/{id}/varyasyonlar', [UrunController::class, 'varyasyonlar'])->name('admin.urunler.varyasyonlar');
    Route::post('urunler/{id}/varyasyonlar', [UrunController::class, 'varyasyonKaydet'])->name('admin.urunler.varyasyonKaydet');
    Route::delete('urunler/varyasyon/{id}', [UrunController::class, 'varyasyonSil'])->name('admin.urunler.varyasyonSil');

    // Yeni Eklenen: Sayfalar (CMS)
    Route::resource('sayfalar', AdminSayfaController::class)
        ->names('admin.sayfalar')
        ->except(['show']);
        
    // Anasayfa Blokları Yönetimi
    Route::resource('anasayfa-bloklari', \App\Http\Controllers\Admin\AnasayfaBlokController::class)
        ->names('admin.anasayfa-bloklari')
        ->except(['show']);

    // Çıkış (Hem GET hem POST destekli)
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout.post');
    
});

Route::get('/kategori/{slug}', [KategoriSayfaController::class, 'goster'])->name('kategori.goster');
    Route::get('/urun/{slug}', [UrunDetayController::class, 'goster'])->name('urun.detay');


Route::get('/kendi-kutunu-yap', [OzelKutuController::class, 'index'])->name('kendi.kutunu.yap');
Route::post('/kendi-kutunu-yap/sepete-ekle', [OzelKutuController::class, 'sepeteEkle'])->name('kutu.sepete.ekle');