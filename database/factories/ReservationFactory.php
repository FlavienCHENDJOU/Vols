<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'vol_id' => \App\Models\Vol::inRandomOrder()->first()->id, // associe à un vol existant
        'nom' => $this->faker->lastName,
        'prenom' =>$this->faker->firstName,
        'email' => $this->faker->unique()->safeEmail,
        'telephone' =>$this->faker->phoneNumber,
        'nombre_places' => $this->faker->numberBetween(1, 5),
        ];
    }
}
