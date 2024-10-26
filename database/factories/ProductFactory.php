<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->word();
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $name,
            'description' => fake()->paragraph(),
            'price' => fake()->randomNumber(5, true),
            'stock' => fake()->randomDigitNot(0),
            'image' => 'https://placehold.co/800@3x.png?text='.$name,
            'status' => fake()->randomElement(['0','1'])
        ];
    }
}
