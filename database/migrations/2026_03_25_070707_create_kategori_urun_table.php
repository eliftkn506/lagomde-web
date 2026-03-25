<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('kategori_urun', function (Blueprint $table) {
            $table->foreignId('kategori_id')->constrained('kategoriler')->onDelete('cascade');
            $table->foreignId('urun_id')->constrained('urunler')->onDelete('cascade');
            $table->primary(['kategori_id', 'urun_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('kategori_urun'); }
};
