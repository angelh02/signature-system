<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->bothify('dv##??##??'),
            'name' => $this->faker->name()
        ];
    }
}
