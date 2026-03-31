<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ozel_kutular', function (Blueprint $table) {
            // ->onDelete('restrict') kısmını kaldırdık
            $table->foreignId('kutu_varyasyon_id')
                  ->nullable()
                  ->after('session_id')
                  ->constrained('urun_varyasyonlari');
                  
            $table->text('hediye_notu')->nullable()->after('kutu_varyasyon_id');
        });
    }

    public function down(): void
    {
        Schema::table('ozel_kutular', function (Blueprint $table) {
            // Geri alma işlemi (rollback) durumunda önce foreign key'i, sonra sütunları sileriz
            $table->dropForeign(['kutu_varyasyon_id']);
            $table->dropColumn(['kutu_varyasyon_id', 'hediye_notu']);
        });
    }
};