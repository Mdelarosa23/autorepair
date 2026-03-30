<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@madsautorepair.com')],
            [
                'name' => env('ADMIN_NAME', 'Admin User'),
                'password' => env('ADMIN_PASSWORD', 'admin12345'),
            ]
        );

        $defaults = [
            'light_accent' => '#fdb819',
            'light_background' => '#ffffff',
            'light_text' => '#000000',
            'dark_accent' => '#fdb819',
            'dark_background' => '#1d1d1d',
            'dark_text' => '#ffffff',
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
