<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('kullanicilar', function (Blueprint $table) {
            $table->id();
            $table->string('ad', 50);
            $table->string('soyad', 50);
            $table->string('eposta')->unique();
            $table->string('sifre');
            $table->string('telefon', 20)->nullable();
            $table->enum('uyelik_tipi', ['bireysel', 'kurumsal'])->default('bireysel');
            $table->string('sirket_adi')->nullable();
            $table->string('vergi_dairesi')->nullable();
            $table->string('vergi_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('kullanicilar'); }
};
