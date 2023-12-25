<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([ConfigSeeder::class, AdminSeeder::class]);

        \App\Models\Admin::factory(20)->create();
        \App\Models\Teacher::factory(50)->create();
        \App\Models\Classroom::factory(20)->create();
        \App\Models\Subject::factory(25)->create();
        \App\Models\Schedule::factory(50)->create();
        \App\Models\Student::factory(500)->create();
    }
}
