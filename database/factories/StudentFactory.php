<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classroomIDs = Classroom::query()
            ->pluck('id');

        return [
            'nisn' => $this->faker->unique()->numerify('##########'),
            'name' => $this->faker->name,
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement([Gender::MALE->value, Gender::FEMALE->value]),
            'address' => $this->faker->address(),
            'password' => Hash::make('password'),
            'classroom_id' => $this->faker->randomElement($classroomIDs),
        ];
    }
}
