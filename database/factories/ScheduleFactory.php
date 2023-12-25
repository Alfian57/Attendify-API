<?php

namespace Database\Factories;

use App\Enums\Day;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timeFinish = $this->faker->time();

        $teacherIDs = Teacher::query()
            ->pluck('id');

        $subjectIDs = Subject::query()
            ->pluck('id');

        $classroomIDs = Classroom::query()
            ->pluck('id');

        return [
            'teacher_id' => $this->faker->randomElement($teacherIDs),
            'subject_id' => $this->faker->randomElement($subjectIDs),
            'classroom_id' => $this->faker->randomElement($classroomIDs),
            'day' => $this->faker->randomElement(array_column(Day::cases(), 'value')),
            'time_start' => $this->faker->time('H:i:s', $timeFinish),
            'time_finish' => $timeFinish,
        ];
    }
}
