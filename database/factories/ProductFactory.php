<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;

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
        
        $name = $this->faker->words(3, true);
        $price = $this->faker->randomFloat(2, 10, 1000);
        
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(5),
            'price' => $price,
            'compare_price' => $this->faker->boolean(30) ? $price * 1.2 : null,
            'stock' => $this->faker->numberBetween(0, 200),
            'sku' => 'SKU-' . strtoupper($this->faker->unique()->bothify('???-###')),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
        ];

    }
}
