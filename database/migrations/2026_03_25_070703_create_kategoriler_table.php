<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('kategoriler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ust_kategori_id')->nullable()->constrained('kategoriler')->onDelete('no action');
            $table->string('ad', 100);
            $table->string('slug')->unique();
            $table->string('gorsel_url')->nullable();
            $table->boolean('aktif_mi')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('kategoriler'); }
};
