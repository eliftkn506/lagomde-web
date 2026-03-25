<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('zamanli_teslimatlar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siparis_id')->constrained('siparisler')->onDelete('cascade');
            $table->date('teslimat_tarihi');
            $table->string('saat_araligi', 50);
        });
    }
    public function down(): void { Schema::dropIfExists('zamanli_teslimatlar'); }
};
