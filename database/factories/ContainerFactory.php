<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>  substr($this->faker->name(),0,29),
            'effective_date' => $this->faker->date()
        ];
    }
}
