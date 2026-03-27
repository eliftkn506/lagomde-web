<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('anasayfa_bloklari', function (Blueprint $table) {
            $table->id();
            // Bloğun ne olduğunu belirler (örn: 'vitrin', 'ikonlar', 'banner', 'koleksiyon')
            $table->string('tip'); 
            
            // Bloğun üstünde çıkacak genel başlıklar
            $table->string('baslik')->nullable();
            $table->string('alt_baslik')->nullable();
            
            // Eğer bloğun genel bir yönlendirme butonu varsa
            $table->string('buton_metni')->nullable();
            $table->string('buton_linki')->nullable();
            
            // EN ÖNEMLİ ALAN: Her bloğun farklılaşan verilerini (resimler, ikonlar, yazılar) burada esnek bir dizi (Array/JSON) olarak tutacağız.
            $table->json('icerik_verisi')->nullable(); 
            
            // Admin panelinden açıp kapatmak için
            $table->boolean('aktif_mi')->default(true);
            
            // Anasayfadaki yukarıdan aşağıya sıralamayı belirlemek için
            $table->integer('sira')->default(0); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anasayfa_bloklari');
    }
};