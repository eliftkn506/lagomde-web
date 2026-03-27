<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Kategori;
use App\Models\Sayfa; // Sayfa modelini ekledik

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            
            // 1. Kategorileri Çek (Senin yazdığın mevcut kod)
            $anaMenuler = Kategori::with('altKategoriler.altKategoriler')
                                  ->whereNull('ust_kategori_id')
                                  ->orderBy('id', 'asc')
                                  ->get();
                                  
            // 2. Footer CMS Sayfalarını Çek (Yeni eklenen kod)
            $sayfalar = Sayfa::where('aktif_mi', true)->orderBy('sira', 'asc')->get();
            
            // Tüm verileri view'a gönderiyoruz
            $view->with([
                'anaMenuler'        => $anaMenuler,
                'footerKurumsal'    => $sayfalar->where('footer_konum', 'kurumsal'),
                'footerYardim'      => $sayfalar->where('footer_konum', 'yardim'),
                'footerSozlesmeler' => $sayfalar->where('footer_konum', 'sozlesmeler'),
            ]);
            
        });
    }
}