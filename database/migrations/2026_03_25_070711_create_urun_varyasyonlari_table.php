<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('urun_varyasyonlari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urun_id')->constrained('urunler')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('barkod')->unique()->nullable();
            $table->decimal('normal_fiyat', 10, 2);
            $table->decimal('indirimli_fiyat', 10, 2)->nullable();
            $table->integer('anlik_stok')->default(0);
            $table->boolean('aktif_mi')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('urun_varyasyonlari'); }
};
