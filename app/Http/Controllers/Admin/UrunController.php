<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Kategori;
use App\Models\UrunVaryasyonu;
use App\Models\UrunGorseli;
use App\Models\Ozellik;
use App\Models\OzellikDegeri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UrunController extends Controller
{
    // ══════════════════════════════════════════════════════
    // 1. LİSTE
    // ══════════════════════════════════════════════════════
    public function index()
    {
        $urunler = Urun::with([
            'kategoriler',
            'gorseller',
            'varyasyonlar.ozellikDegerleri.ozellik',
        ])->orderBy('id', 'desc')->paginate(15);

        return view('admin.urunler.index', compact('urunler'));
    }

    // ══════════════════════════════════════════════════════
    // 2. EKLEME FORMU
    // ══════════════════════════════════════════════════════
    public function create()
    {
        $kategoriler = Kategori::with('altKategoriler.altKategoriler')
                               ->whereNull('ust_kategori_id')
                               ->orderBy('ad', 'asc')
                               ->get();

        return view('admin.urunler.create', compact('kategoriler'));
    }

    // ══════════════════════════════════════════════════════
    // 3. KAYDETME
    // ══════════════════════════════════════════════════════
    public function store(Request $request)
    {
        $request->validate([
            'ad'             => 'required|string|max:255',
            'kategoriler'    => 'required|array|min:1',
            'normal_fiyat'   => 'required|numeric|min:0',
            'anlik_stok'     => 'required|integer|min:0',
            'ana_gorsel'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ek_gorseller.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'kategoriler.required' => 'Lütfen en az 1 kategori seçin.',
            'kategoriler.min'      => 'Lütfen en az 1 kategori seçin.',
        ]);

        DB::beginTransaction();
        try {
            $urun = Urun::create([
                'ad'               => $request->ad,
                'slug'             => Str::slug($request->ad) . '-' . rand(1000, 9999),
                'kisa_aciklama'    => $request->kisa_aciklama,
                'detayli_aciklama' => $request->detayli_aciklama,
                'urun_tipi'        => $request->has('varyasyonlu_mu') ? 'Varyasyonlu' : 'Tekil',
                'varyasyonlu_mu'   => $request->has('varyasyonlu_mu') ? 1 : 0,
                'aktif_mi'         => $request->has('aktif_mi') ? 1 : 0,
            ]);

            $urun->kategoriler()->sync($request->kategoriler);

            UrunVaryasyonu::create([
                'urun_id'         => $urun->id,
                'sku'             => $request->sku    ?? strtoupper(Str::random(8)),
                'barkod'          => $request->barkod ?? strtoupper(Str::random(10)),
                'normal_fiyat'    => $request->normal_fiyat,
                'indirimli_fiyat' => $request->indirimli_fiyat ?: null,
                'anlik_stok'      => $request->anlik_stok,
                'aktif_mi'        => 1,
            ]);

            $this->gorselKaydet($urun->id, $request);

            DB::commit();

            if ($urun->varyasyonlu_mu) {
                return redirect()->route('admin.urunler.varyasyonlar', $urun->id)
                    ->with('success', 'Ürün eklendi! Şimdi varyasyonları tanımlayın.');
            }

            return redirect()->route('admin.urunler.index')
                ->with('success', '"' . $urun->ad . '" başarıyla eklendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['Hata: ' . $e->getMessage()]);
        }
    }

    // ══════════════════════════════════════════════════════
    // 4. DÜZENLEME FORMU
    // ══════════════════════════════════════════════════════
    public function edit($id)
    {
        $urun = Urun::with([
            'kategoriler',
            'gorseller',
            'varyasyonlar',
        ])->findOrFail($id);

        $kategoriler = Kategori::with('altKategoriler.altKategoriler')
                               ->whereNull('ust_kategori_id')
                               ->orderBy('ad', 'asc')
                               ->get();

        $seciliKategoriler = $urun->kategoriler->pluck('id')->toArray();
        $standartVaryasyon = $urun->varyasyonlar->first();

        return view('admin.urunler.edit', compact(
            'urun', 'kategoriler', 'seciliKategoriler', 'standartVaryasyon'
        ));
    }

    // ══════════════════════════════════════════════════════
    // 5. GÜNCELLEME
    // ══════════════════════════════════════════════════════
    public function update(Request $request, $id)
    {
        $urun = Urun::findOrFail($id);

        $request->validate([
            'ad'             => 'required|string|max:255',
            'kategoriler'    => 'required|array|min:1',
            'normal_fiyat'   => 'required|numeric|min:0',
            'anlik_stok'     => 'required|integer|min:0',
            'ana_gorsel'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ek_gorseller.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'kategoriler.required' => 'Lütfen en az 1 kategori seçin.',
        ]);

        DB::beginTransaction();
        try {
            $urun->update([
                'ad'               => $request->ad,
                'kisa_aciklama'    => $request->kisa_aciklama,
                'detayli_aciklama' => $request->detayli_aciklama,
                'urun_tipi'        => $request->has('varyasyonlu_mu') ? 'Varyasyonlu' : 'Tekil',
                'varyasyonlu_mu'   => $request->has('varyasyonlu_mu') ? 1 : 0,
                'aktif_mi'         => $request->has('aktif_mi') ? 1 : 0,
            ]);

            $urun->kategoriler()->sync($request->kategoriler);

            // Standart varyasyonun fiyat/stok güncelleme
            $sv = $urun->varyasyonlar()->first();
            if ($sv) {
                $sv->update([
                    'sku'             => $request->sku ?? $sv->sku,
                    'normal_fiyat'    => $request->normal_fiyat,
                    'indirimli_fiyat' => $request->indirimli_fiyat ?: null,
                    'anlik_stok'      => $request->anlik_stok,
                ]);
            }

            // Yeni ana görsel yüklendiyse eski sira=1'i sil
            if ($request->hasFile('ana_gorsel')) {
                $eskiAna = $urun->gorseller()->where('sira', 1)->first();
                if ($eskiAna) {
                    $this->dosyaSil($eskiAna->gorsel_url);
                    $eskiAna->delete();
                }
            }

            // Mevcut en yüksek sırayı bul
            $maxSira = $urun->gorseller()->max('sira') ?? 0;
            $this->gorselKaydet($urun->id, $request, $maxSira);

            DB::commit();

            return redirect()->route('admin.urunler.index')
                ->with('success', '"' . $urun->ad . '" başarıyla güncellendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['Güncelleme hatası: ' . $e->getMessage()]);
        }
    }

    // ══════════════════════════════════════════════════════
    // 6. SİLME (Soft Delete + ilişki temizliği)
    // ══════════════════════════════════════════════════════
    public function destroy($id)
    {
        try {
            $urun = Urun::with(['gorseller', 'varyasyonlar'])->findOrFail($id);
            $ad   = $urun->ad;

            DB::beginTransaction();

            foreach ($urun->varyasyonlar as $v) {
                $v->ozellikDegerleri()->detach();
                $v->delete();
            }

            foreach ($urun->gorseller as $g) {
                $this->dosyaSil($g->gorsel_url);
                $g->delete();
            }

            $urun->kategoriler()->detach();
            $urun->delete(); // SoftDelete

            DB::commit();

            return redirect()->route('admin.urunler.index')
                ->with('success', '"' . $ad . '" başarıyla silindi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Silme hatası: ' . $e->getMessage()]);
        }
    }

    // ══════════════════════════════════════════════════════
    // 7. TEK GÖRSEL SİLME (edit sayfasından AJAX)
    // ══════════════════════════════════════════════════════
    public function gorselSil(Request $request, $gorselId)
    {
        try {
            $gorsel = UrunGorseli::findOrFail($gorselId);
            $urunId = $gorsel->urun_id;

            // Silinen ana görsel (sira=1) ise, bir sonrakini ana yap
            if ((int)$gorsel->sira === 1) {
                $sonraki = UrunGorseli::where('urun_id', $urunId)
                                      ->where('id', '!=', $gorselId)
                                      ->orderBy('sira')
                                      ->first();
                if ($sonraki) {
                    $sonraki->update(['sira' => 1]);
                }
            }

            $this->dosyaSil($gorsel->gorsel_url);
            $gorsel->delete();

            if ($request->wantsJson()) {
                return response()->json(['success' => true]);
            }

            return back()->with('success', 'Görsel silindi.');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['Görsel silme hatası: ' . $e->getMessage()]);
        }
    }

    // ══════════════════════════════════════════════════════
    // 8. VARYASYON SAYFASI
    // ══════════════════════════════════════════════════════
    public function varyasyonlar($id)
    {
        $urun          = Urun::with(['varyasyonlar.ozellikDegerleri.ozellik'])->findOrFail($id);
        $tumOzellikler = Ozellik::all();

        return view('admin.urunler.varyasyonlar', compact('urun', 'tumOzellikler'));
    }

    // ══════════════════════════════════════════════════════
    // 9. VARYASYON KAYDETME
    // ══════════════════════════════════════════════════════
    public function varyasyonKaydet(Request $request, $id)
    {
        $request->validate([
            'ozellik_ad_1'    => 'required|string',
            'ozellik_deger_1' => 'required|string',
            'normal_fiyat'    => 'required|numeric|min:0',
            'anlik_stok'      => 'required|integer|min:0',
        ]);

        $urun = Urun::findOrFail($id);

        DB::beginTransaction();
        try {
            $varyasyon = UrunVaryasyonu::create([
                'urun_id'         => $urun->id,
                'sku'             => $request->sku    ?? strtoupper(Str::random(8)),
                'barkod'          => $request->barkod ?? strtoupper(Str::random(10)),
                'normal_fiyat'    => $request->normal_fiyat,
                'indirimli_fiyat' => $request->indirimli_fiyat ?: null,
                'anlik_stok'      => $request->anlik_stok,
                'aktif_mi'        => 1,
            ]);

            $degerIdleri = [];
            $oz1 = Ozellik::firstOrCreate(['ad' => $request->ozellik_ad_1]);
            $dg1 = OzellikDegeri::firstOrCreate(['ozellik_id' => $oz1->id, 'deger' => $request->ozellik_deger_1]);
            $degerIdleri[] = $dg1->id;

            if ($request->filled('ozellik_ad_2') && $request->filled('ozellik_deger_2')) {
                $oz2 = Ozellik::firstOrCreate(['ad' => $request->ozellik_ad_2]);
                $dg2 = OzellikDegeri::firstOrCreate(['ozellik_id' => $oz2->id, 'deger' => $request->ozellik_deger_2]);
                $degerIdleri[] = $dg2->id;
            }

            $varyasyon->ozellikDegerleri()->sync($degerIdleri);

            DB::commit();
            return back()->with('success', 'Varyasyon başarıyla eklendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Hata: ' . $e->getMessage()]);
        }
    }

    // ══════════════════════════════════════════════════════
    // 10. VARYASYON SİLME
    // ══════════════════════════════════════════════════════
    public function varyasyonSil($id)
    {
        try {
            $varyasyon = UrunVaryasyonu::findOrFail($id);
            $varyasyon->ozellikDegerleri()->detach();
            $varyasyon->delete();
            return back()->with('success', 'Seçenek başarıyla silindi!');
        } catch (\Exception $e) {
            return back()->withErrors(['Silme hatası: ' . $e->getMessage()]);
        }
    }

    // ══════════════════════════════════════════════════════
    // YARDIMCI — Görsel yükle & kaydet
    // ══════════════════════════════════════════════════════
    private function gorselKaydet(int $urunId, Request $request, int $mevcutMaxSira = 0): void
    {
        $klasor = public_path('uploads/urunler');
        if (!File::exists($klasor)) {
            File::makeDirectory($klasor, 0755, true);
        }

        if ($request->hasFile('ana_gorsel') && $request->file('ana_gorsel')->isValid()) {
            $dosya = $request->file('ana_gorsel');
            $ad    = time() . '_main.' . $dosya->extension();
            $dosya->move($klasor, $ad);

            UrunGorseli::create([
                'urun_id'      => $urunId,
                'varyasyon_id' => null,
                'gorsel_url'   => 'uploads/urunler/' . $ad,
                'sira'         => 1,
            ]);

            $mevcutMaxSira = max($mevcutMaxSira, 1);
        }

        if ($request->hasFile('ek_gorseller')) {
            $sira = max($mevcutMaxSira + 1, 2);

            foreach ($request->file('ek_gorseller') as $dosya) {
                if (!$dosya->isValid()) continue;

                $ad = time() . '_' . $sira . '_' . rand(100, 999) . '.' . $dosya->extension();
                $dosya->move($klasor, $ad);

                UrunGorseli::create([
                    'urun_id'      => $urunId,
                    'varyasyon_id' => null,
                    'gorsel_url'   => 'uploads/urunler/' . $ad,
                    'sira'         => $sira,
                ]);
                $sira++;
            }
        }
    }

    // ══════════════════════════════════════════════════════
    // YARDIMCI — Diskten dosya sil
    // ══════════════════════════════════════════════════════
    private function dosyaSil(string $gorselUrl): void
    {
        $yol = public_path($gorselUrl);
        if (File::exists($yol)) {
            File::delete($yol);
        }
    }
}