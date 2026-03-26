<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->rememberToken(); // remember_token NVARCHAR(100) NULL
        });
    }

    public function down(): void
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
