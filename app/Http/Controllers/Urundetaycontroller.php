<?php

// ════════════════════════════════════════════════════════
// app/Http/Controllers/UrunDetayController.php
// Ürün detay sayfası controller'ı
// ════════════════════════════════════════════════════════

namespace App\Http\Controllers;

use App\Models\Urun;
use Illuminate\Http\Request;

class UrunDetayController extends Controller
{
    public function goster($slug)
    {
        // Ürünü ilişkileriyle birlikte getir
        $urun = Urun::with([
            'kategoriler.ustKategori',
            'gorseller',
            'varyasyonlar.ozellikDegerleri.ozellik',
            'degerlendirmeler.kullanici', // Degerlendirme modeli varsa
        ])->where('slug', $slug)
          ->where('aktif_mi', true)
          ->firstOrFail();

        // Benzer ürünleri çek (aynı kategoriden, bu ürün hariç)
        $kategoriIds = $urun->kategoriler->pluck('id');

        $benzerUrunler = Urun::with(['kategoriler', 'gorseller', 'varyasyonlar'])
            ->where('aktif_mi', true)
            ->where('id', '!=', $urun->id)
            ->whereHas('kategoriler', fn($q) => $q->whereIn('kategoriler.id', $kategoriIds))
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('urun-detay', compact('urun', 'benzerUrunler'));
    }
}