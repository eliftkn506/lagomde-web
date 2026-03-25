<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('b2b_kurumsal_talepler', function (Blueprint $table) {
            $table->id();
            $table->string('sirket_adi');
            $table->string('ad_soyad');
            $table->string('eposta');
            $table->string('telefon');
            $table->integer('personel_sayisi');
            $table->text('talep_detayi');
            $table->enum('durum', ['yeni', 'gorusuluyor', 'teklif_verildi', 'kapandi'])->default('yeni');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('b2b_kurumsal_talepler'); }
};
