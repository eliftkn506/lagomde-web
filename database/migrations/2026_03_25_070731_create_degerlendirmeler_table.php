<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('degerlendirmeler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urun_id')->constrained('urunler')->onDelete('cascade');
            $table->foreignId('kullanici_id')->constrained('kullanicilar')->onDelete('cascade');
            $table->tinyInteger('puan');
            $table->text('yorum')->nullable();
            $table->boolean('onay_durumu')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('degerlendirmeler'); }
};
