<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
        Schema::create('ozellik_degerleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ozellik_id')->constrained('ozellikler')->onDelete('cascade');
            $table->string('deger', 50);
        });
    }
    public function down(): void { Schema::dropIfExists('ozellik_degerleri'); }
};
