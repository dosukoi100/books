<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('examples', function (Blueprint $table) {
            //追加
            $table->string('name');
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examples', function (Blueprint $table) {
            //ロールバック
            $table->dropColumn('name');
            $table->dropColumn('address');
        });
    }
};
