<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Thứ tự QUAN TRỌNG
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            RoleSeeder::class, // 👈 THÊM (chạy sau để không xóa dữ liệu quan trọng)
        ]);
    }
}