<?php

namespace Database\Factories;

use App\Enums\ProductStatusEnum;
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
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'old_price' => $this->faker->numberBetween(1, 1000),
            'sale_price' => $this->faker->numberBetween(1, 1000),
            'thumb' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(ProductStatusEnum::cases())->value,
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'options' => [
                'color' => [
                    fake()->hexColor(),
                    fake()->hexColor(),
                    fake()->hexColor(),
                ],
                'size' => [
                    fake()->word(),
                    fake()->word(),
                    fake()->word(),
                ],
            ],
        ];
    }
}
