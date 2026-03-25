<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('sepet_kalemleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sepet_id')->constrained('sepetler')->onDelete('cascade');
            $table->foreignId('varyasyon_id')->nullable()->constrained('urun_varyasyonlari')->onDelete('cascade');
            $table->foreignId('ozel_kutu_id')->nullable()->constrained('ozel_kutular')->onDelete('no action');
            $table->integer('miktar');
            $table->text('kisisel_not')->nullable();
            $table->string('baski_gorsel_url')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sepet_kalemleri'); }
};
