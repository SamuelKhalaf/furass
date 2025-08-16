<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'telephone'      => '010000000',
            'facebook'       => 'https://facebook.com',
            'linkedin'       => 'https://linkedin.com',
            'instagram'      => 'https://instagram.com',
            'support_hours'  => 'Sat - Thu 9:00 am to 5:00 pm',
            'head_office'  => '638 star Aveno , Jeddah',
            'email'  => 'furasshead@furass.com',
        ];

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],      // condition
                ['value' => $value]   // data to update/insert
            );
        }
    }
}
