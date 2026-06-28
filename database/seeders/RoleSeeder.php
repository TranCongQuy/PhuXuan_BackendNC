<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa dữ liệu test cũ (nếu có)
        User::where('email', 'like', '%@test.com')->delete();

        // Tạo Admin
        $admin = User::create([
            'name' => 'Admin Lê',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Tạo Editor
        $editor = User::create([
            'name' => 'Editor Phạm',
            'email' => 'editor@test.com',
            'password' => bcrypt('password'),
            'role' => 'editor',
        ]);

        // Tạo User Alice
        $alice = User::create([
            'name' => 'Alice Nguyễn',
            'email' => 'alice@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Tạo User Bob
        $bob = User::create([
            'name' => 'Bob Trần',
            'email' => 'bob@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Tạo 3 bài viết của Alice
        Post::factory()->count(3)->create([
            'user_id' => $alice->id,
            'status' => 'published',
        ]);

        // Tạo 2 bài viết của Bob
        Post::factory()->count(2)->create([
            'user_id' => $bob->id,
            'status' => 'published',
        ]);

        // Tạo 1 bài viết của Editor
        Post::factory()->count(1)->create([
            'user_id' => $editor->id,
            'status' => 'published',
        ]);

        $this->command->info('✅ Đã tạo user:');
        $this->command->info('  - admin@test.com / password (Admin)');
        $this->command->info('  - editor@test.com / password (Editor)');
        $this->command->info('  - alice@test.com / password (User)');
        $this->command->info('  - bob@test.com / password (User)');
    }
}