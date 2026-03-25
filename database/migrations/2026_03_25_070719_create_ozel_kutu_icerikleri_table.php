<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('ozel_kutu_icerikleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ozel_kutu_id')->constrained('ozel_kutular')->onDelete('cascade');
            $table->foreignId('varyasyon_id')->constrained('urun_varyasyonlari')->onDelete('cascade');
            $table->integer('miktar');
            $table->decimal('eklendigi_fiyat', 10, 2);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ozel_kutu_icerikleri'); }
};
