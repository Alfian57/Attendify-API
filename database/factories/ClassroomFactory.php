<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teacherIDs = Teacher::query()
            ->whereNotIn('id', function ($query) {
                $query->select('teacher_id')->from('classrooms');
            })
            ->pluck('id');

        return [
            'name' => $this->faker->unique()->sentence(3),
            'teacher_id' => $this->faker->randomElement($teacherIDs),
        ];
    }
}
