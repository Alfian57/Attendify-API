<?php

namespace Database\Factories;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement([Gender::MALE->value, Gender::FEMALE->value]),
            'address' => $this->faker->address(),
            'password' => Hash::make('password'),
        ];
    }
}
