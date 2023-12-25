<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Alfian Gading Saputra',
            'email' => 'gading@gmail.com',
            'date_of_birth' => now(),
            'gender' => Gender::MALE->value,
            'address' => 'Yogyakarta, Banguntapan, Bantul',
            'password' => Hash::make('password'),
        ]);
    }
}
