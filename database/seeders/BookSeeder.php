<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//追加:Bookモデルの呼び出し
use App\Models\Book;

//追加:ファサードでのDB呼び出し
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Bookファクトリで作成した仮想データを作る
        Book::factory()->count(3)->create();
    }
}
