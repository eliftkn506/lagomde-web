<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\AnasayfaBlok; // Dinamik blok modelini ekledik
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Kategori Vitrini (Sol büyük + sağ 6'lı grid) için veriler (Mevcut yapı)
        // Eğer veritabanında kategorilerin varsa ilk 7 tanesini çeker.
        $vitrinKategorileri = Kategori::whereNull('ust_kategori_id')->take(7)->get();

        // 2. ADMİN PANELİNDEN EKLENEN DİNAMİK BLOKLAR (İşte burası eksikti!)
        // Sadece "aktif" olanları alıp "sira" numarasına göre sıralıyoruz.
        $dinamikBloklar = AnasayfaBlok::where('aktif_mi', true)->orderBy('sira', 'asc')->get();

        // İki veriyi de 'welcome' (anasayfa) görünümüne gönderiyoruz
        return view('welcome', compact('vitrinKategorileri', 'dinamikBloklar'));
    }
}