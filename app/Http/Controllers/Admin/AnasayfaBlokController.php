<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnasayfaBlok;
use Illuminate\Http\Request;

class AnasayfaBlokController extends Controller
{
    // 1. Listeleme Ekranı
    public function index()
    {
        // Blokları 'sira' sütununa göre küçükten büyüğe sıralayarak getiriyoruz
        $bloklar = AnasayfaBlok::orderBy('sira', 'asc')->get();
        return view('admin.anasayfa_bloklari.index', compact('bloklar'));
    }

    // 2. Yeni Ekleme Ekranı (Bir sonraki adımda tasarlayacağız)
    public function create()
    {
        return view('admin.anasayfa_bloklari.create');
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'tip' => 'required|string',
        ]);

        $icerikVerisi = $request->input('icerik_verisi', []);

        // 1. Full Banner
        if ($request->hasFile('icerik_verisi.arka_plan')) {
            $path = $request->file('icerik_verisi.arka_plan')->store('anasayfa_bloklari', 'public');
            $icerikVerisi['arka_plan'] = $path;
        }

        // 2. Özel Koleksiyonlar
        if ($request->has('icerik_verisi.koleksiyonlar')) {
            foreach ($request->icerik_verisi['koleksiyonlar'] as $key => $koleksiyon) {
                if ($request->hasFile("icerik_verisi.koleksiyonlar.{$key}.resim")) {
                    $path = $request->file("icerik_verisi.koleksiyonlar.{$key}.resim")->store('anasayfa_bloklari', 'public');
                    $icerikVerisi['koleksiyonlar'][$key]['resim'] = $path;
                }
            }
        }

        // 3. İlham Galerisi
        if ($request->has('icerik_verisi.galeri')) {
            foreach ($request->icerik_verisi['galeri'] as $key => $galeriItem) {
                if ($request->hasFile("icerik_verisi.galeri.{$key}.resim")) {
                    $path = $request->file("icerik_verisi.galeri.{$key}.resim")->store('anasayfa_bloklari', 'public');
                    $icerikVerisi['galeri'][$key]['resim'] = $path;
                }
            }
        }

        AnasayfaBlok::create([
            'tip'           => $request->tip,
            'baslik'        => $request->baslik,
            'alt_baslik'    => $request->alt_baslik,
            'buton_metni'   => $request->buton_metni,
            'buton_linki'   => $request->buton_linki,
            'icerik_verisi' => $icerikVerisi, 
            'aktif_mi'      => $request->has('aktif_mi'),
            'sira'          => $request->sira ?? 0,
        ]);

        return redirect()->route('admin.anasayfa-bloklari.index')->with('success', 'Yeni anasayfa modülü başarıyla oluşturuldu.');
    }

    // --- DÜZENLEME EKRANI ---
    public function edit($id)
    {
        $blok = AnasayfaBlok::findOrFail($id);
        return view('admin.anasayfa_bloklari.edit', compact('blok'));
    }

    // --- GÜNCELLEME İŞLEMİ ---
    public function update(Request $request, $id)
    {
        $blok = AnasayfaBlok::findOrFail($id);

        $request->validate([
            'tip' => 'required|string',
        ]);

        $icerikVerisi = $request->input('icerik_verisi', []);
        $eskiIcerik = $blok->icerik_verisi ?? [];

        // 1. Full Banner Resim Güncelleme
        if ($request->tip == 'full_banner') {
            if ($request->hasFile('icerik_verisi.arka_plan')) {
                if (isset($eskiIcerik['arka_plan'])) \Illuminate\Support\Facades\Storage::disk('public')->delete($eskiIcerik['arka_plan']);
                $icerikVerisi['arka_plan'] = $request->file('icerik_verisi.arka_plan')->store('anasayfa_bloklari', 'public');
            } else {
                $icerikVerisi['arka_plan'] = $eskiIcerik['arka_plan'] ?? null; // Yeni resim yoksa eskiyi koru
            }
        }

        // 2. Özel Koleksiyonlar Resim Güncelleme
        if ($request->tip == 'koleksiyon_grid' && isset($icerikVerisi['koleksiyonlar'])) {
            foreach ($icerikVerisi['koleksiyonlar'] as $key => $kol) {
                if ($request->hasFile("icerik_verisi.koleksiyonlar.{$key}.resim")) {
                    if (isset($eskiIcerik['koleksiyonlar'][$key]['resim'])) \Illuminate\Support\Facades\Storage::disk('public')->delete($eskiIcerik['koleksiyonlar'][$key]['resim']);
                    $icerikVerisi['koleksiyonlar'][$key]['resim'] = $request->file("icerik_verisi.koleksiyonlar.{$key}.resim")->store('anasayfa_bloklari', 'public');
                } else {
                    $icerikVerisi['koleksiyonlar'][$key]['resim'] = $eskiIcerik['koleksiyonlar'][$key]['resim'] ?? null;
                }
            }
        }

        // 3. İlham Galerisi Resim Güncelleme
        if ($request->tip == 'galeri' && isset($icerikVerisi['galeri'])) {
            foreach ($icerikVerisi['galeri'] as $key => $gItem) {
                if ($request->hasFile("icerik_verisi.galeri.{$key}.resim")) {
                    if (isset($eskiIcerik['galeri'][$key]['resim'])) \Illuminate\Support\Facades\Storage::disk('public')->delete($eskiIcerik['galeri'][$key]['resim']);
                    $icerikVerisi['galeri'][$key]['resim'] = $request->file("icerik_verisi.galeri.{$key}.resim")->store('anasayfa_bloklari', 'public');
                } else {
                    $icerikVerisi['galeri'][$key]['resim'] = $eskiIcerik['galeri'][$key]['resim'] ?? null;
                }
            }
        }

        $blok->update([
            'tip'           => $request->tip,
            'baslik'        => $request->baslik,
            'alt_baslik'    => $request->alt_baslik,
            'buton_metni'   => $request->buton_metni,
            'buton_linki'   => $request->buton_linki,
            'icerik_verisi' => $icerikVerisi,
            'aktif_mi'      => $request->has('aktif_mi'),
            'sira'          => $request->sira ?? 0,
        ]);

        return redirect()->route('admin.anasayfa-bloklari.index')->with('success', 'Anasayfa bloğu başarıyla güncellendi.');
    }

    // --- SİLME İŞLEMİ ---
    public function destroy($id)
    {
        $blok = AnasayfaBlok::findOrFail($id);
        $icerik = $blok->icerik_verisi ?? [];

        // Sunucudan Resimleri Temizle
        if (isset($icerik['arka_plan'])) \Illuminate\Support\Facades\Storage::disk('public')->delete($icerik['arka_plan']);
        
        if (isset($icerik['koleksiyonlar'])) {
            foreach ($icerik['koleksiyonlar'] as $kol) {
                if (isset($kol['resim'])) \Illuminate\Support\Facades\Storage::disk('public')->delete($kol['resim']);
            }
        }
        
        if (isset($icerik['galeri'])) {
            foreach ($icerik['galeri'] as $gItem) {
                if (isset($gItem['resim'])) \Illuminate\Support\Facades\Storage::disk('public')->delete($gItem['resim']);
            }
        }

        $blok->delete();
        return redirect()->route('admin.anasayfa-bloklari.index')->with('success', 'Blok ve ilgili görseller tamamen silindi.');
    }

    
}