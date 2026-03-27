<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('sayfalar', function (Blueprint $table) {
            $table->id();
            $table->string('baslik');
            // SEO dostu URL'ler için (örn: lagomde.com/s/biz-kimiz)
            $table->string('slug')->unique(); 
            // Uzun metinler ve HTML etiketleri (CKEditor vb. ile eklenecek) için longText
            $table->longText('icerik')->nullable(); 
            // Footer'da hangi sütunda çıkacak? (kurumsal, yardim, sozlesmeler)
            $table->string('footer_konum')->nullable(); 
            $table->boolean('aktif_mi')->default(true);
            $table->integer('sira')->default(0); // Menüdeki sıralama önceliği
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sayfalar');
    }
};
