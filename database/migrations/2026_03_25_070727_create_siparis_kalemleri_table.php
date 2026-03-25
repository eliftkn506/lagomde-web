<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('siparis_kalemleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siparis_id')->constrained('siparisler')->onDelete('cascade');
            $table->foreignId('varyasyon_id')->nullable()->constrained('urun_varyasyonlari')->onDelete('set null');
            $table->foreignId('ozel_kutu_id')->nullable()->constrained('ozel_kutular')->onDelete('set null');
            $table->integer('miktar');
            $table->decimal('birim_fiyat', 10, 2);
            $table->text('kisisel_not')->nullable();
            $table->string('baski_gorsel_url')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('siparis_kalemleri'); }
};
