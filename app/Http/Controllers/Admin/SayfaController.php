<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sayfa;
use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sayfa;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Slug oluşturmak için

class SayfaController extends Controller
{
    // Sayfaların listelendiği tablo ekranı
    public function index()
    {
        $sayfalar = Sayfa::orderBy('sira', 'asc')->get();
        return view('admin.sayfalar.index', compact('sayfalar'));
    }

    // Yeni sayfa ekleme formu
    public function create()
    {
        return view('admin.sayfalar.create');
    }

    // Formdan gelen veriyi veritabanına kaydetme
    public function store(Request $request)
    {
        $request->validate([
            'baslik' => 'required|max:255',
            'icerik' => 'required',
            'footer_konum' => 'required'
        ]);

        Sayfa::create([
            'baslik' => $request->baslik,
            // Başlıktan otomatik SEO uyumlu slug üretiyoruz
            'slug' => Str::slug($request->baslik), 
            'icerik' => $request->icerik,
            'footer_konum' => $request->footer_konum,
            'aktif_mi' => $request->has('aktif_mi'),
            'sira' => $request->sira ?? 0
        ]);

        return redirect()->route('admin.sayfalar.index')->with('success', 'Sayfa başarıyla eklendi.');
    }
    public function destroy($id)
    {
        $sayfa = Sayfa::findOrFail($id);
        $sayfa->delete();

        return redirect()->route('admin.sayfalar.index')->with('success', 'Sayfa başarıyla silindi.');
    }
}
