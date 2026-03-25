<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('siparisler', function (Blueprint $table) {
            $table->id();
            $table->string('siparis_kodu')->unique();
            $table->foreignId('kullanici_id')->constrained('kullanicilar')->onDelete('no action');
            $table->enum('durum', ['onay_bekliyor', 'hazirlaniyor', 'kargoda', 'teslim_edildi', 'iptal', 'iade'])->default('onay_bekliyor');
            $table->decimal('ara_toplam', 10, 2);
            $table->decimal('kargo_tutari', 10, 2);
            $table->decimal('indirim_tutari', 10, 2)->default(0);
            $table->decimal('genel_toplam', 10, 2);
            $table->foreignId('teslimat_adresi_id')->constrained('adresler')->onDelete('no action');
            $table->foreignId('fatura_adresi_id')->constrained('adresler')->onDelete('no action');
            $table->foreignId('kupon_id')->nullable()->constrained('kuponlar')->onDelete('set null');
            $table->string('kargo_firmasi', 50)->nullable();
            $table->string('kargo_takip_kodu', 100)->nullable();
            $table->text('hediye_notu')->nullable();
            $table->boolean('gondericiyi_gizle')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('siparisler'); }
};
