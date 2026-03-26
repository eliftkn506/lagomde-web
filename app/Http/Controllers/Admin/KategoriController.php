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
        ]);

        // URL için slug oluştur (Örn: "Doğum Günü" -> "dogum-gunu")
        $slug = Str::slug($request->ad);
        
        // Eğer aynı slug'dan varsa sonuna rastgele sayı ekle ki çakışmasın
        if (Kategori::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . rand(100, 999);
        }

        Kategori::create([
            'ad' => $request->ad,
            'slug' => $slug,
            'ust_kategori_id' => $request->ust_kategori_id,
        ]);

        // İşlem bitince sayfaya geri dön ve başarı mesajı gönder
        return back()->with('success', 'Kategori başarıyla eklendi.');
    }
}