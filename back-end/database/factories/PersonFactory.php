<?php

namespace Database\Factories;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');
        return [
            'name' => $faker->name(''),
            'cpf' => Helpers::unmask($faker->cpf),
            'rg' => Helpers::unmask($faker->rg),
            'birth_date' =>$faker->dateTimeBetween('-30 years', '-10 years'),
            'sex_id' => rand(1,2),
        ];
    }

}
