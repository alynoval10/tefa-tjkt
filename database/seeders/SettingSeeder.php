<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'school_name'    => 'SMKN 1 Krangkeng',
                'tefa_name'      => 'Teaching Factory TJKT',
                'department_name'=> 'Teknik Jaringan Komputer dan Telekomunikasi',
            ]
        );
    }
}