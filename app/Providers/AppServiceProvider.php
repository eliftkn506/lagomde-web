<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Kategori;
use App\Models\Sayfa;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Üst Menü Kategorileri
            $anaMenuler = Kategori::with('altKategoriler.altKategoriler')
                                ->whereNull('ust_kategori_id')
                                ->orderBy('id', 'asc')
                                ->get();

            // Sayfaları tek sorguda çekip filter ile dağıtıyoruz (Performans için)
            $sayfalar = Sayfa::where('aktif_mi', 1)->orderBy('sira', 'asc')->get();

            $view->with([
                'anaMenuler'        => $anaMenuler,
                'footerKurumsal'    => $sayfalar->where('footer_konum', 'kurumsal'),
                'footerYardim'      => $sayfalar->where('footer_konum', 'yardim'),
                'footerSozlesmeler' => $sayfalar->where('footer_konum', 'sozlesmeler'),
            ]);
        });
    }
}