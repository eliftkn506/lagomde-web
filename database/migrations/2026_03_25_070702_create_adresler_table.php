<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('adresler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kullanici_id')->constrained('kullanicilar')->onDelete('cascade');
            $table->string('baslik', 50);
            $table->string('ad_soyad', 100);
            $table->string('telefon', 20);
            $table->string('sehir', 50);
            $table->string('ilce', 50);
            $table->text('acik_adres');
            $table->enum('adres_tipi', ['teslimat', 'fatura', 'ikisi'])->default('ikisi');
            $table->boolean('aktif_mi')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('adresler'); }
};
