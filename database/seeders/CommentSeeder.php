<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 200 comment ngẫu nhiên
        Comment::factory()->count(200)->create();
    }
}