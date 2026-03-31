<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Urun;
use App\Models\OzelKutu;
use App\Models\OzelKutuIcerigi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OzelKutuController extends Controller
{
    // ══════════════════════════════════════════════════════
    // 1. ÖN YÜZÜ GÖSTER (Kutular ve Ürünler)
    // ══════════════════════════════════════════════════════
    public function index()
    {
        // 1. Ambalajları (Boş Kutuları) Çekiyoruz
        // Not: Admin panelinden slug'ı "bos-kutular" olan bir kategori açmalısın.
        $kutuKategorisi = Kategori::where('slug', 'bos-kutular')->first();
        $kutular = $kutuKategorisi 
            ? $kutuKategorisi->urunler()->with(['varyasyonlar', 'gorseller'])->where('aktif_mi', 1)->get() 
            : collect();

        // 2. Kutuya Eklenecek Hediyeleri Çekiyoruz
        // SADECE adminden "Özel Kutuda Göster" dediğimiz kategoriler gelecek!
        $icerikKategorileri = Kategori::with(['urunler' => function($q) {
            $q->with(['varyasyonlar', 'gorseller'])->where('aktif_mi', 1);
        }])
        ->where('ozel_kutuda_goster', 1)
        ->where('slug', '!=', 'bos-kutular') // Boş kutuları hediyeler arasında göstermemek için
        ->get();

        // Verileri kendi-kutunu-yap.blade.php sayfasına gönder
        return view('kendi-kutunu-yap', compact('kutular', 'icerikKategorileri'));
    }

    // ══════════════════════════════════════════════════════
    // 2. AJAX İLE SEPETE EKLEME İŞLEMİ
    // ══════════════════════════════════════════════════════
    public function sepeteEkle(Request $request)
    {
        $request->validate([
            'kutu_varyasyon_id' => 'required|exists:urun_varyasyonlari,id',
            'icerikler'         => 'required|array|min:1',
            'icerikler.*.id'    => 'required|exists:urun_varyasyonlari,id',
            'icerikler.*.adet'  => 'required|integer|min:1',
            'icerikler.*.fiyat' => 'required|numeric',
            'kutu_fiyat'        => 'required|numeric',
            'not'               => 'nullable|string'
        ]);

        // Toplam fiyatı hesapla (Kutu + İçindekiler)
        $toplamFiyat = $request->kutu_fiyat;
        foreach ($request->icerikler as $icerik) {
            $toplamFiyat += ($icerik['fiyat'] * $icerik['adet']);
        }

        // Misafir kullanıcılar için session başlat
        if (!Auth::check() && !session()->isStarted()) {
            session()->start();
        }

        // 1. OzelKutu Kaydı Oluştur
        $ozelKutu = OzelKutu::create([
            'kullanici_id'      => Auth::id(),
            'session_id'        => Auth::check() ? null : session()->getId(),
            'kutu_varyasyon_id' => $request->kutu_varyasyon_id,
            'hediye_notu'       => $request->not,
            'toplam_fiyat'      => $toplamFiyat,
            'durum'             => 'sepette'
        ]);

        // 2. Kutunun İçeriklerini Ekle
        foreach ($request->icerikler as $icerik) {
            OzelKutuIcerigi::create([
                'ozel_kutu_id'    => $ozelKutu->id,
                'varyasyon_id'    => $icerik['id'],
                'miktar'          => $icerik['adet'],
                'eklendigi_fiyat' => $icerik['fiyat']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kutunuz başarıyla hazırlandı ve sepete eklendi!'
        ]);
    }
}