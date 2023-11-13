<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //仮想のデータを作成

            'name' => fake()->name(),
            //randomElement括弧内をランダムに選択
            'status' => fake()->randomElement([1,2,3,4]),
            'author' => fake()->name(),
            'publication' => fake()->name(),
            //date 日時の作成
            'read_at' => fake()->date(),
            //realText テキストを作成(デフォルト200文字)
            'note' => fake()->realText(201),

        ];
    }
}
