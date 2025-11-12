<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // الرياض
            ['name' => 'الرياض', 'region_id' => 1],
            ['name' => 'الخرج', 'region_id' => 1],
            ['name' => 'الدرعية', 'region_id' => 1],
            // مكة المكرمة
            ['name' => 'مكة المكرمة', 'region_id' => 2],
            ['name' => 'جدة', 'region_id' => 2],
            ['name' => 'الطائف', 'region_id' => 2],
            // المدينة المنورة
            ['name' => 'المدينة المنورة', 'region_id' => 3],
            ['name' => 'ينبع', 'region_id' => 3],
            // القصيم
            ['name' => 'بريدة', 'region_id' => 4],
            ['name' => 'عنيزة', 'region_id' => 4],
            // الشرقية
            ['name' => 'الدمام', 'region_id' => 5],
            ['name' => 'الخبر', 'region_id' => 5],
            ['name' => 'الظهران', 'region_id' => 5],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}