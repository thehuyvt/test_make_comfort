<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'product_variant_id' => ProductVariant::inRandomOrder()->first()->id ?? ProductVariant::factory(),
            'thumb' => $this->faker->imageUrl(),
            'price' => $this->faker->numberBetween(1, 1000),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
