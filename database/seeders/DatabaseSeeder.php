<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Thứ tự QUAN TRỌNG: User → Category → Tag → Post → Comment
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,      // Tags cần tồn tại trước khi gán cho Post
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }
}