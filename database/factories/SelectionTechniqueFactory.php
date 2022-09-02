<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SelectionTechniqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->bothify('st##??##??'),
            'name' => $this->faker->name()
        ];
    }
}
