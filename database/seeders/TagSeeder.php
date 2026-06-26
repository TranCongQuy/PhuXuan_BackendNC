<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['Laravel', 'PHP', 'Backend', 'API', 'Tutorial'];

        foreach ($tags as $name) {
            Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // Gắn tag ngẫu nhiên cho các bài viết hiện có
        $posts = \App\Models\Post::all();
        $tagIds = Tag::pluck('id')->toArray();

        foreach ($posts as $post) {
            $randomTagIds = collect($tagIds)->random(min(3, count($tagIds)))->toArray();
            $post->tags()->sync($randomTagIds);
        }
    }
}