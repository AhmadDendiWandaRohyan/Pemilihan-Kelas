<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Config::insert([
            [
                'code' => 'default_password',
                'value' => 'admin',
            ],
            [
                'code' => 'page_size',
                'value' => '10',
            ],
            [
                'code' => 'app_name',
                'value' => 'Aplikasi KRS SMA',
            ],
            [
                'code' => 'institution_name',
                'value' => 'SMA',
            ],
            [
                'code' => 'institution_address',
                'value' => 'Jl. Pati Tayu',
            ],
            [
                'code' => 'institution_phone',
                'value' => '082121212121',
            ],
            [
                'code' => 'institution_email',
                'value' => 'admin@admin.com',
            ],
            [
                'code' => 'language',
                'value' => 'id',
            ],
            [
                'code' => 'pic',
                'value' => 'Ahmad Dendi',
            ],
        ]);
    }
}