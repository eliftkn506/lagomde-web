<?php

// ════════════════════════════════════════════════════════
// app/Http/Controllers/KategoriSayfaController.php
// Kategori ürün listesi sayfası controller'ı
// ════════════════════════════════════════════════════════

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Urun;
use App\Models\Ozellik;
use Illuminate\Http\Request;

class KategoriSayfaController extends Controller
{
    public function goster(Request $request, $slug)
    {
        // Kategoriyi çek (alt kategorileriyle birlikte)
        $kategori = Kategori::with([
            'altKategoriler',
            'ustKategori',
        ])->where('slug', $slug)->firstOrFail();

        // Alt kategori filter
        $altKategoriSlug = $request->get('alt');

        // Ürün query başlat
        $query = Urun::with([
            'kategoriler',
            'gorseller',
            'varyasyonlar',
        ])->where('aktif_mi', true);

        // Bu kategoriye veya alt kategorilerine ait ürünleri getir
        if ($altKategoriSlug) {
            $altKat = Kategori::where('slug', $altKategoriSlug)->first();
            if ($altKat) {
                $query->whereHas('kategoriler', fn($q) => $q->where('kategoriler.id', $altKat->id));
            }
        } else {
            // Ana kategori + tüm alt kategoriler
            $tumKatIds = collect([$kategori->id])
                ->merge($kategori->altKategoriler->pluck('id'))
                ->merge($kategori->altKategoriler->flatMap(fn($a) => $a->altKategoriler->pluck('id')));

            $query->whereHas('kategoriler', fn($q) => $q->whereIn('kategoriler.id', $tumKatIds));
        }

        // Fiyat filtresi
        if ($request->filled('min_fiyat') || $request->filled('max_fiyat')) {
            $minF = $request->get('min_fiyat', 0);
            $maxF = $request->get('max_fiyat', 999999);
            $query->whereHas('varyasyonlar', function ($q) use ($minF, $maxF) {
                $q->whereBetween('normal_fiyat', [$minF, $maxF]);
            });
        }

        // Stok filtresi
        if ($request->boolean('stok_var')) {
            $query->whereHas('varyasyonlar', fn($q) => $q->where('anlik_stok', '>', 0));
        }

        // İndirimli filtresi
        if ($request->boolean('indirimli')) {
            $query->whereHas('varyasyonlar', fn($q) => $q->whereNotNull('indirimli_fiyat'));
        }

        // Sıralama
        switch ($request->get('siralama')) {
            case 'fiyat_asc':
                $query->join('urun_varyasyonlari as uv_sort', 'urunler.id', '=', 'uv_sort.urun_id')
                      ->orderBy('uv_sort.normal_fiyat', 'asc')
                      ->select('urunler.*');
                break;
            case 'fiyat_desc':
                $query->join('urun_varyasyonlari as uv_sort', 'urunler.id', '=', 'uv_sort.urun_id')
                      ->orderBy('uv_sort.normal_fiyat', 'desc')
                      ->select('urunler.*');
                break;
            case 'yeni':
                $query->orderBy('urunler.created_at', 'desc');
                break;
            default:
                $query->orderBy('urunler.id', 'desc');
        }

        $urunler = $query->paginate(24)->withQueryString();

        // Sidebar için özellikler
        $ozellikler = Ozellik::with(['degerler.varyasyonlar'])->get();

        return view('kategori', compact('kategori', 'urunler', 'ozellikler'));
    }

    // Tüm ürünler sayfası (kategorisiz)
    public function tumUrunler(Request $request)
    {
        $query = Urun::with(['kategoriler', 'gorseller', 'varyasyonlar'])
                     ->where('aktif_mi', true);

        // Aynı filtreler
        if ($request->filled('min_fiyat') || $request->filled('max_fiyat')) {
            $query->whereHas('varyasyonlar', fn($q) =>
                $q->whereBetween('normal_fiyat', [
                    $request->get('min_fiyat', 0),
                    $request->get('max_fiyat', 999999),
                ])
            );
        }

        switch ($request->get('siralama')) {
            case 'yeni': $query->orderBy('created_at', 'desc'); break;
            default:     $query->orderBy('id', 'desc');
        }

        $urunler  = $query->paginate(24)->withQueryString();
        $ozellikler = Ozellik::with(['degerler.varyasyonlar'])->get();

        // Sahte kategori objesi (view tutarlılığı için)
        $kategori = (object)[
            'ad'             => 'Tüm Ürünler',
            'gorsel'         => null,
            'slug'           => 'tum-urunler',
            'altKategoriler' => collect(),
            'ustKategori'    => null,
        ];

        return view('kategori', compact('kategori', 'urunler', 'ozellikler'));
    }
}