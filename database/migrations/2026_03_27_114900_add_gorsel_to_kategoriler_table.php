<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('kategoriler', function (Blueprint $table) {
        $table->string('gorsel')->nullable()->after('slug'); // Görsel sütunu eklendi
    });
}
public function down()
{
    Schema::table('kategoriler', function (Blueprint $table) {
        $table->dropColumn('gorsel');
    });
}
};
