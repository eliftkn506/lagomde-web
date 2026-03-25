<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('stok_hareketleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('varyasyon_id')->constrained('urun_varyasyonlari')->onDelete('cascade');
            $table->unsignedBigInteger('siparis_id')->nullable()->index(); 
            $table->enum('hareket_tipi', ['giris', 'cikis', 'iade', 'fire']);
            $table->integer('miktar');
            $table->text('aciklama')->nullable();
            $table->timestamp('islem_tarihi')->useCurrent();
        });
    }
    public function down(): void { Schema::dropIfExists('stok_hareketleri'); }
};
