<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrderPaymentMethodEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'customer_id' => Customer::factory(),
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'note' => $this->faker->text,
            'status' => $this->faker->randomElement(OrderStatusEnum::cases())->value,
            'total' => $this->faker->numberBetween(1000, 100000),
            'approved_at' => $this->faker->optional()->dateTimeBetween('-15 days', 'now'),
            'placed_at' => $this->faker->optional()->dateTimeBetween('-15 days', 'now'),
            'payment_method' => $this->faker->randomElement(OrderPaymentMethodEnum::cases())->value,
        ];
    }
}
