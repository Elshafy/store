<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'amount' => $this->faker->numberBetween(10, 40)
        ];
    }
}