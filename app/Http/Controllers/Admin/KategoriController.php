<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Slug üretmek için gerekli

class KategoriController extends Controller
{
    public function index()
    {
        $kategoriler = Kategori::with('ustKategori')->orderBy('id', 'desc')->paginate(15);
        
        // Modal içindeki dropdown için tüm kategorileri üst kategorileriyle birlikte çekiyoruz
        $tumKategoriler = Kategori::with('ustKategori')->get();

        return view('admin.kategoriler.index', compact('kategoriler', 'tumKategoriler'));
    }

    // YENİ EKLENEN METOD
   public function store(Request $request)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'ust_kategori_id' => 'nullable|exists:kategoriler,id',
            'gorsel' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Resim doğrulaması
        ]);

        $slug = Str::slug($request->ad);
        
        if (Kategori::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . rand(100, 999);
        }

        // Resim yükleme işlemi
        $gorselYolu = null;
        if ($request->hasFile('gorsel')) {
            $gorselYolu = $request->file('gorsel')->store('kategoriler', 'public');
        }

        Kategori::create([
            'ad' => $request->ad,
            'slug' => $slug,
            'ust_kategori_id' => $request->ust_kategori_id,
            'gorsel' => $gorselYolu, // Veritabanına kaydet
        ]);

        return back()->with('success', 'Kategori resmiyle birlikte başarıyla eklendi.');
    }

    // Kategori Düzenleme Ekranı
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        // Kendisini üst kategori olarak seçmesini engellemek için listeyi filtreliyoruz
        $tumKategoriler = Kategori::with('ustKategori')->where('id', '!=', $id)->get();

        return view('admin.kategoriler.edit', compact('kategori', 'tumKategoriler'));
    }

    // Kategori Güncelleme İşlemi
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'ad' => 'required|string|max:255',
            'ust_kategori_id' => 'nullable|exists:kategoriler,id',
            'gorsel' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Slug (URL) Güncelleme
        $slug = Str::slug($request->ad);
        if (Kategori::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $slug . '-' . rand(100, 999);
        }

        // Yeni resim yüklendiyse
        if ($request->hasFile('gorsel')) {
            // Eski resmi sunucudan sil (Yer kaplamaması için)
            if ($kategori->gorsel && \Illuminate\Support\Facades\Storage::disk('public')->exists($kategori->gorsel)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($kategori->gorsel);
            }
            // Yeni resmi yükle
            $kategori->gorsel = $request->file('gorsel')->store('kategoriler', 'public');
        }

        $kategori->ad = $request->ad;
        $kategori->slug = $slug;
        $kategori->ust_kategori_id = $request->ust_kategori_id;
        $kategori->save();

        return redirect()->route('admin.kategoriler.index')->with('success', 'Kategori başarıyla güncellendi.');
    }

    // Kategori Silme İşlemi
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Varsa resmini de sunucudan sil
        if ($kategori->gorsel && \Illuminate\Support\Facades\Storage::disk('public')->exists($kategori->gorsel)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($kategori->gorsel);
        }
        
        $kategori->delete();

        return redirect()->route('admin.kategoriler.index')->with('success', 'Kategori başarıyla silindi.');
    }
}