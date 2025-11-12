<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['name' => 'الرياض'],
            ['name' => 'مكة المكرمة'],
            ['name' => 'المدينة المنورة'],
            ['name' => 'القصيم'],
            ['name' => 'الشرقية'],
            ['name' => 'عسير'],
            ['name' => 'تبوك'],
            ['name' => 'حائل'],
            ['name' => 'الحدود الشمالية'],
            ['name' => 'جازان'],
            ['name' => 'نجران'],
            ['name' => 'الباحة'],
            ['name' => 'الجوف'],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}