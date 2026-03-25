<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('urunler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('slug')->unique();
            $table->text('kisa_aciklama');
            $table->longText('detayli_aciklama');
            $table->enum('urun_tipi', ['standart', 'dijital', 'kutu_ici'])->default('standart');
            $table->boolean('varyasyonlu_mu')->default(false);
            $table->boolean('aktif_mi')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('urunler'); }
};
