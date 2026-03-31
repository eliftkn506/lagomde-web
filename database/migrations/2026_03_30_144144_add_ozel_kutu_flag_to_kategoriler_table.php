<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('kategoriler', function (Blueprint $table) {
        // Bu kategori Kendi Kutunu Yap modülünde çıkacak mı?
        $table->boolean('ozel_kutuda_goster')->default(0)->after('ust_kategori_id');
    });
}

public function down(): void
{
    Schema::table('kategoriler', function (Blueprint $table) {
        $table->dropColumn('ozel_kutuda_goster');
    });
}
};
