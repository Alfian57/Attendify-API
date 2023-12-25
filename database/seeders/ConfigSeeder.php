<?php

namespace Database\Seeders;

use App\Enums\Config as EnumsConfig;
use App\Models\Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::create([
            'name' => EnumsConfig::QR_CODE->value,
            'value' => Str::random(255),
        ]);

        Config::create([
            'name' => EnumsConfig::ATTENDANCE_TIME_START->value,
            'value' => '06.30',
        ]);

        Config::create([
            'name' => EnumsConfig::ATTENDANCE_TIME_END->value,
            'value' => '07.30',
        ]);
    }
}
