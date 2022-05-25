<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realTextBetween(10, 20),
            'content' => $this->faker->realTextBetween(150, 300),
            'authorized_area' => $this->faker->numberBetween(1, 20),
            'status' => '1',
        ];
    }
}