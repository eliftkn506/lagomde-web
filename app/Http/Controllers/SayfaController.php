<?php

namespace App\Http\Controllers;

use App\Models\Sayfa;
use Illuminate\Http\Request;

class SayfaController extends Controller
{
    public function goster($slug)
    {
        // Gelen slug'a sahip aktif sayfayı bulur, yoksa 404 hatası döndürür.
        $sayfa = Sayfa::where('slug', $slug)->where('aktif_mi', true)->firstOrFail();
        
        return view('sayfalar.show', compact('sayfa'));
    }
}