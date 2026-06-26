<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 12 danh mục bằng Factory
        Category::factory()->count(12)->create();
    }
}