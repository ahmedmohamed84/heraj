<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'سيارات'],
            ['name' => 'عقارات'],
            ['name' => 'أجهزة'],
            ['name' => 'خدمات'],
            ['name' => 'أثاث'],
            ['name' => 'حيوانات'],
            ['name' => 'مواشي وطيور'],
            ['name' => 'قسم غير مصنف'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}