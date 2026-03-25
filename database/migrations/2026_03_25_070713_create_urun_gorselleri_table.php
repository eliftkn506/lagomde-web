<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('urun_gorselleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urun_id')->constrained('urunler')->onDelete('cascade');
            $table->foreignId('varyasyon_id')->nullable()->constrained('urun_varyasyonlari')->onDelete('no action');
            $table->string('gorsel_url');
            $table->integer('sira')->default(0);
        });
    }
    public function down(): void { Schema::dropIfExists('urun_gorselleri'); }
};
