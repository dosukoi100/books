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
        Schema::create('books', function (Blueprint $table) {
            /* カラムの指定 */
            /* nullableメソッドを付けないとnot null */
            /* commentメソッドでカラムのコメントを残す */
            $table->id(); //idはデフォルトでautoincrement,unique,
            $table->string('name',32)->comment('本の名前');//str型は第一引数カラム名,第二引数文字数(デフォルト255)
            $table->tinyInteger('status')->comment('本のステータス 1;読書中 2;未読 3;読破 4;読みたい');//1から255までのint型
            $table->string('author',32)->nullable()->comment('本の作者');//nullable()でnull okにしている
            $table->string('publication',32)->nullable()->comment('本の出版社');
            $table->date('read_at')->nullable()->comment('本を読み終わった日');//yyyy-mm-dd
            $table->text('note',300)->nullable()->comment('本のコメント');//text型で文字制限300文字(デフォルト500)
            $table->timestamps();//created_at,updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
