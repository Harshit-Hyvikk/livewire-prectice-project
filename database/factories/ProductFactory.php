<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'sku' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{6}'),
            'description' => $this->faker->paragraphs(2, true),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['draft', 'active', 'inactive']),
            'specifications' => [
                'color' => $this->faker->safeColorName,
                'weight' => $this->faker->numberBetween(1, 10) . ' kg',
                'dimensions' => $this->faker->numberBetween(10, 50) . 'x' .
                              $this->faker->numberBetween(10, 50) . 'x' .
                              $this->faker->numberBetween(10, 50) . ' cm'
            ]
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active'
            ];
        });
    }

    public function inStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => $this->faker->numberBetween(1, 100)
            ];
        });
    }
}
