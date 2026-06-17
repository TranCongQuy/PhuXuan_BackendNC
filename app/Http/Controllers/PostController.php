<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = collect([
            (object) [
                'id' => 1,
                'title' => 'Giới thiệu Laravel Framework',
                'body' => 'Laravel là một PHP framework mạnh mẽ, cú pháp đẹp, phù hợp phát triển web hiện đại.',
                'author' => 'Nguyễn Văn An',
                'status' => 'published',
                'created_at' => now()->subDays(5),
            ],
            (object) [
                'id' => 2,
                'title' => 'Routing trong Laravel - Toàn tập',
                'body' => 'Routing là cơ chế ánh xạ URL đến xử lý logic. Laravel hỗ trợ route parameter, named route, group route.',
                'author' => 'Trần Thị Bình',
                'status' => 'published',
                'created_at' => now()->subDays(3),
            ],
            (object) [
                'id' => 3,
                'title' => 'Blade Templates - Hướng dẫn chi tiết',
                'body' => 'Blade là template engine mạnh mẽ với cú pháp đẹp, hỗ trợ layout kế thừa, component.',
                'author' => 'Lê Văn Cường',
                'status' => 'draft',
                'created_at' => now()->subDay(),
            ],
            (object) [
                'id' => 4,
                'title' => 'Eloquent ORM - Làm việc với Database',
                'body' => 'Eloquent là ORM của Laravel, giúp tương tác với database một cách trực quan và dễ dàng.',
                'author' => 'Phạm Thị Dung',
                'status' => 'published',
                'created_at' => now(),
            ],
        ]);

        return view('posts.index', compact('posts'));
    }
}