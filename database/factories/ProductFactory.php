<?php

namespace Database\Factories;

use App\Enums\RetailerEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->name,
            'retailer' => RetailerEnum::Coolblue,
            'price' => $this->faker->numberBetween(0, 1000),
            'url' => $this->faker->domainName,
            'in_stock' => $this->faker->boolean,
        ];
    }
}
