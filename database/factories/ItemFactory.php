<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'code' => $this->faker->name,
            'min' => $this->faker->numberBetween(1, 15),
            'amount' => $this->faker->numberBetween(20, 40),
            'price' => $this->faker->numberBetween(10, 20),
            'image' => $this->faker->name
        ];
    }
}
