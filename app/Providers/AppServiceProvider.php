<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Bunu ekle
use App\Models\Kategori; // Bunu ekle

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            // with('altKategoriler.altKategoriler') diyerek 3. seviyeye kadar tüm ağacı tek seferde çekiyoruz
            $anaMenuler = Kategori::with('altKategoriler.altKategoriler')
                                  ->whereNull('ust_kategori_id')
                                  ->orderBy('id', 'asc')
                                  ->get();
                                  
            $view->with('anaMenuler', $anaMenuler);
        });
    }
}