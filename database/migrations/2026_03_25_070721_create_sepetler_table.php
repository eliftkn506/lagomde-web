<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('sepetler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kullanici_id')->nullable()->constrained('kullanicilar')->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->decimal('toplam_tutar', 10, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sepetler'); }
};
