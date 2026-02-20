<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vol;

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
        'vol_id' => Vol::inRandomOrder()->first()->id, 
        'nom' => $this->faker->lastName,
        'prenom' =>$this->faker->firstName,
        'email' => $this->faker->unique()->safeEmail,
        'telephone' =>$this->faker->phoneNumber,
        'nombre_places' => $this->faker->numberBetween(1, 5),
        ];
    }
}
