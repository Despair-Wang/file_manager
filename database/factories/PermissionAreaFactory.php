<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'permission_id' => $this->faker->numberBetween(1, 20),
            'area_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}