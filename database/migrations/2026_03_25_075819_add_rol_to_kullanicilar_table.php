<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('kullanicilar', function (Blueprint $table) {
        // 'email' sütunundan hemen sonra 'rol' sütununu ekliyoruz
        $table->string('rol')->default('user')->after('email');
    });
}

public function down(): void
{
    Schema::table('kullanicilar', function (Blueprint $table) {
        $table->dropColumn('rol');
    });
}
};
