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

class UrunController extends Controller
{
    // 1. ÜRÜN LİSTELEME SAYFASI
   // 1. ÜRÜN LİSTELEME SAYFASI
    public function index()
    {
        // 'gorseller' kısmındaki orderBy('sira', 'asc') kısmını siliyoruz 
        // Çünkü modelde veya ilişkide muhtemelen zaten tanımlı, bu da SQL Server'da çakışma yapıyor.
        $urunler = Urun::with([
            'kategoriler', 
            'gorseller', // orderBy kısmını buradan kaldırdık
            'varyasyonlar'
        ])->orderBy('id', 'desc')->paginate(15);

        return view('admin.urunler.index', compact('urunler'));
    }

    // 2. YENİ ÜRÜN EKLEME SAYFASI (CREATE)
    public function create()
    {
        // Checkbox'lar için tüm ağacı 3 seviyeli çekiyoruz
        $kategoriler = Kategori::with('altKategoriler.altKategoriler')
                               ->whereNull('ust_kategori_id')
                               ->orderBy('ad', 'asc')
                               ->get();

        return view('admin.urunler.create', compact('kategoriler'));
    }

    // 3. ÜRÜN KAYDETME İŞLEMİ (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'kategoriler' => 'required|array', // En az 1 kategori seçilmeli
            'normal_fiyat' => 'required|numeric',
            'anlik_stok' => 'required|integer',
            'gorseller.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048' // Her görsel max 2MB
        ], [
            'kategoriler.required' => 'Lütfen sağ taraftan en az 1 kategori seçin.'
        ]);

        DB::beginTransaction();

        try {
            // Ana Ürünü Kaydet
            $urun = Urun::create([
                'ad' => $request->ad,
                'slug' => Str::slug($request->ad) . '-' . rand(1000, 9999),
                'kisa_aciklama' => $request->kisa_aciklama,
                'detayli_aciklama' => $request->detayli_aciklama,
                'urun_tipi' => $request->has('varyasyonlu_mu') ? 'Varyasyonlu' : 'Tekil',
                'varyasyonlu_mu' => $request->has('varyasyonlu_mu') ? 1 : 0,
                'aktif_mi' => $request->has('aktif_mi') ? 1 : 0,
            ]);

            // Kategorileri Bağla
            $urun->kategoriler()->sync($request->kategoriler);

            // Standart Fiyat/Stok Kaydı
            UrunVaryasyonu::create([
                'urun_id' => $urun->id,
                'sku' => $request->sku ?? strtoupper(Str::random(8)), 
                'barkod' => $request->barkod ?? strtoupper(Str::random(10)), // NULL hatasını çözen satır
                'normal_fiyat' => $request->normal_fiyat,
                'indirimli_fiyat' => $request->indirimli_fiyat,
                'anlik_stok' => $request->anlik_stok,
                'aktif_mi' => 1
            ]);

            // Görselleri Yükle ve Kaydet
            if ($request->hasFile('gorseller')) {
                foreach ($request->file('gorseller') as $index => $file) {
                    $fileName = time() . '_' . $index . '.' . $file->extension();
                    $file->move(public_path('uploads/urunler'), $fileName);
                    
                    UrunGorseli::create([
                        'urun_id' => $urun->id,
                        'varyasyon_id' => null,
                        'gorsel_url' => 'uploads/urunler/' . $fileName,
                        'sira' => $index + 1
                    ]);
                }
            }

            DB::commit();

            // Yönlendirme
            if ($urun->varyasyonlu_mu) {
                return redirect()->route('admin.urunler.varyasyonlar', $urun->id)
                                 ->with('success', 'Ana ürün başarıyla eklendi. Lütfen şimdi özelliklerini tanımlayın.');
            }

            return redirect()->route('admin.urunler.index')->with('success', 'Ürün başarıyla eklendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Sistemsel bir hata oluştu: ' . $e->getMessage()]);
        }
    }

    // 4. VARYASYON YÖNETİM SAYFASI
    public function varyasyonlar($id)
    {
        $urun = Urun::with(['varyasyonlar.ozellikDegerleri.ozellik'])->findOrFail($id);
        $tumOzellikler = Ozellik::all();

        return view('admin.urunler.varyasyonlar', compact('urun', 'tumOzellikler'));
    }

    // 5. YENİ VARYASYON KAYDETME İŞLEMİ
    public function varyasyonKaydet(Request $request, $id)
    {
        $request->validate([
            'ozellik_ad_1' => 'required|string',
            'ozellik_deger_1' => 'required|string',
            'normal_fiyat' => 'required|numeric',
            'anlik_stok' => 'required|integer',
        ]);

        $urun = Urun::findOrFail($id);

        DB::beginTransaction();

        try {
            // Varyasyonu Oluştur
            $varyasyon = UrunVaryasyonu::create([
                'urun_id' => $urun->id,
                'sku' => $request->sku ?? strtoupper(Str::random(8)), 
                'barkod' => $request->barkod ?? strtoupper(Str::random(10)), // NULL hatasını çözen satır
                'normal_fiyat' => $request->normal_fiyat,
                'indirimli_fiyat' => $request->indirimli_fiyat,
                'anlik_stok' => $request->anlik_stok,
                'aktif_mi' => 1
            ]);

            $ozellikDegerIdleri = [];

            // 1. Özellik (Zorunlu)
            $ozellik1 = Ozellik::firstOrCreate(['ad' => $request->ozellik_ad_1]);
            $deger1 = OzellikDegeri::firstOrCreate([
                'ozellik_id' => $ozellik1->id,
                'deger' => $request->ozellik_deger_1
            ]);
            $ozellikDegerIdleri[] = $deger1->id;

            // 2. Özellik (Opsiyonel)
            if ($request->filled('ozellik_ad_2') && $request->filled('ozellik_deger_2')) {
                $ozellik2 = Ozellik::firstOrCreate(['ad' => $request->ozellik_ad_2]);
                $deger2 = OzellikDegeri::firstOrCreate([
                    'ozellik_id' => $ozellik2->id,
                    'deger' => $request->ozellik_deger_2
                ]);
                $ozellikDegerIdleri[] = $deger2->id;
            }

            // Pivot tablo eşleşmesi
            $varyasyon->ozellikDegerleri()->sync($ozellikDegerIdleri);

            DB::commit();

            return back()->with('success', 'Varyasyon başarıyla eklendi!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Hata oluştu: ' . $e->getMessage()]);
        }
    }
    // 6. VARYASYON SİLME İŞLEMİ
    public function varyasyonSil($id)
    {
        try {
            $varyasyon = UrunVaryasyonu::findOrFail($id);
            
            // Önce pivot tablodaki (renk, beden vb.) eşleşmelerini koparıyoruz
            $varyasyon->ozellikDegerleri()->detach();
            
            // Sonra varyasyonu tamamen siliyoruz
            $varyasyon->delete();

            return back()->with('success', 'Seçenek başarıyla silindi!');
        } catch (\Exception $e) {
            return back()->withErrors(['Silme işlemi sırasında hata oluştu: ' . $e->getMessage()]);
        }
    }
}