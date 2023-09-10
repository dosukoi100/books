<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

//追加:Exampleモデルの呼び出し
use App\Models\Example;

//追加:ファサードでのDB呼び出し
use Illuminate\Support\Facades\DB;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('examples')->insert([
        //    'id' => 11,
        //]);

        Example::factory()->count(3)->create();


    }
}
