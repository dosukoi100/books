<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Example>
 */
class ExampleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //Laravel10公式
            'name' => fake()->name(),
            'address' => fake()->address()
            //教材Laravel9
            //'name' => $this->faker->name(),
            //'address' => $this->faker->address()
        ];
    }
}
