<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Storage facade'ı eklendi

class KategoriController extends Controller
{
    public function index()
    {
        $kategoriler = Kategori::with('ustKategori')->orderBy('id', 'desc')->paginate(15);
        
        // Modal içindeki dropdown için tüm kategorileri üst kategorileriyle birlikte çekiyoruz
        $tumKategoriler = Kategori::with('ustKategori')->get();

        return view('admin.kategoriler.index', compact('kategoriler', 'tumKategoriler'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'ust_kategori_id' => 'nullable|exists:kategoriler,id',
            'gorsel' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
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
            'ad'                 => $request->ad,
            'slug'               => $slug,
            'ust_kategori_id'    => $request->ust_kategori_id,
            'gorsel'             => $gorselYolu,
            'ozel_kutuda_goster' => $request->has('ozel_kutuda_goster') ? 1 : 0, // YENİ EKLENDİ
        ]);

        return back()->with('success', 'Kategori başarıyla eklendi.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $tumKategoriler = Kategori::with('ustKategori')->where('id', '!=', $id)->get();

        return view('admin.kategoriler.edit', compact('kategori', 'tumKategoriler'));
    }

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
            // Eski resmi sunucudan sil
            if ($kategori->gorsel && Storage::disk('public')->exists($kategori->gorsel)) {
                Storage::disk('public')->delete($kategori->gorsel);
            }
            // Yeni resmi yükle
            $kategori->gorsel = $request->file('gorsel')->store('kategoriler', 'public');
        }

        $kategori->ad = $request->ad;
        $kategori->slug = $slug;
        $kategori->ust_kategori_id = $request->ust_kategori_id;
        $kategori->ozel_kutuda_goster = $request->has('ozel_kutuda_goster') ? 1 : 0; // YENİ EKLENDİ
        $kategori->save();

        return redirect()->route('admin.kategoriler.index')->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Varsa resmini de sunucudan sil
        if ($kategori->gorsel && Storage::disk('public')->exists($kategori->gorsel)) {
            Storage::disk('public')->delete($kategori->gorsel);
        }
        
        $kategori->delete();

        return redirect()->route('admin.kategoriler.index')->with('success', 'Kategori başarıyla silindi.');
    }
}