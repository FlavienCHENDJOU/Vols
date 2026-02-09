<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'depart' => $this->faker->city,
        'destination' =>$this->faker->city,
        'date_depart' => $this->faker->date(),
        'heure_depart' =>$this->faker->time(),
        'places_disponibles' => $this->faker->numberBetween(10, 150),
        'prix' =>$this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
