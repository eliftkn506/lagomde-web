<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('ozel_kutular', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kullanici_id')->nullable()->constrained('kullanicilar')->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->decimal('toplam_fiyat', 10, 2)->default(0);
            $table->enum('durum', ['taslak', 'sepette', 'satildi'])->default('taslak');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ozel_kutular'); }
};
