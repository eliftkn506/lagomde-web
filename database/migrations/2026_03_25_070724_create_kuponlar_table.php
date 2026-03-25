<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('kuponlar', function (Blueprint $table) {
            $table->id();
            $table->string('kod')->unique();
            $table->enum('indirim_tipi', ['yuzde', 'sabit']);
            $table->decimal('deger', 10, 2);
            $table->decimal('alt_limit', 10, 2)->nullable();
            $table->dateTime('bitis_tarihi')->nullable();
            $table->integer('kullanim_limiti')->nullable();
            $table->boolean('aktif_mi')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kuponlar'); }
};
