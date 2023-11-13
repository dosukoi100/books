<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //ここにシーダーを記述することによりクラス名無しで
        //シーダーを実行できる

        //ExampleSeederのシーダーの呼び出し
        $this->call([
            ExampleSeeder::class,
        ]);

        //BookSeederの呼び出し
        $this->call([
            BookSeeder::class,
        ]);
    }
}
