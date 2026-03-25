<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('varyasyon_deger_eslesmeleri', function (Blueprint $table) {
            $table->foreignId('varyasyon_id')->constrained('urun_varyasyonlari')->onDelete('cascade');
            $table->foreignId('ozellik_deger_id')->constrained('ozellik_degerleri')->onDelete('cascade');
            $table->primary(['varyasyon_id', 'ozellik_deger_id'], 'var_deger_pk');
        });
    }
    public function down(): void { Schema::dropIfExists('varyasyon_deger_eslesmeleri'); }
};
