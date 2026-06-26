<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Hiển thị danh sách bài viết
    public function index()
    {
        $articles = [
            ['id' => 1, 'title' => 'Giới thiệu Laravel Framework', 'author' => 'Nguyễn Văn A', 'date' => '2024-01-15'],
            ['id' => 2, 'title' => 'Routing trong Laravel - Toàn tập', 'author' => 'Trần Thị B', 'date' => '2024-01-18'],
            ['id' => 3, 'title' => 'Blade Templates - Hướng dẫn chi tiết', 'author' => 'Lê Văn C', 'date' => '2024-01-22'],
            ['id' => 4, 'title' => 'Eloquent ORM - Làm việc với Database', 'author' => 'Phạm Thị D', 'date' => '2024-01-25'],
        ];
        return view('articles.index', compact('articles'));
    }

    // Hiển thị form tạo bài viết mới
    public function create()
    {
        return view('articles.create');
    }

    // Lưu bài viết mới (tạm thời redirect)
    public function store(Request $request)
    {
        return redirect()->route('articles.index');
    }

    // Hiển thị chi tiết 1 bài viết
    public function show(string $id)
    {
        $allArticles = [
            1 => ['id' => 1, 'title' => 'Giới thiệu Laravel Framework', 'author' => 'Nguyễn Văn A', 'date' => '2024-01-15', 'content' => 'Laravel là một PHP framework mạnh mẽ, cú pháp đẹp.'],
            2 => ['id' => 2, 'title' => 'Routing trong Laravel - Toàn tập', 'author' => 'Trần Thị B', 'date' => '2024-01-18', 'content' => 'Routing là cơ chế ánh xạ URL đến xử lý logic.'],
            3 => ['id' => 3, 'title' => 'Blade Templates - Hướng dẫn chi tiết', 'author' => 'Lê Văn C', 'date' => '2024-01-22', 'content' => 'Blade là template engine mạnh mẽ.'],
            4 => ['id' => 4, 'title' => 'Eloquent ORM - Làm việc với Database', 'author' => 'Phạm Thị D', 'date' => '2024-01-25', 'content' => 'Eloquent là ORM của Laravel.'],
        ];

        if (!isset($allArticles[$id])) {
            abort(404, 'Bài viết không tồn tại');
        }

        $article = $allArticles[$id];
        return view('articles.show', compact('article'));
    }
    public function edit($id)
    {
        // Lấy dữ liệu bài viết giả (giống như trong show)
        $allArticles = [
            1 => ['id' => 1, 'title' => 'Giới thiệu Laravel Framework', 'author' => 'Nguyễn Văn A', 'date' => '2024-01-15', 'content' => 'Laravel là một PHP framework mạnh mẽ...'],
            2 => ['id' => 2, 'title' => 'Routing trong Laravel - Toàn tập', 'author' => 'Trần Thị B', 'date' => '2024-01-18', 'content' => 'Routing là cơ chế ánh xạ URL...'],
            3 => ['id' => 3, 'title' => 'Blade Templates - Hướng dẫn chi tiết', 'author' => 'Lê Văn C', 'date' => '2024-01-22', 'content' => 'Blade là template engine mạnh mẽ...'],
            4 => ['id' => 4, 'title' => 'Eloquent ORM - Làm việc với Database', 'author' => 'Phạm Thị D', 'date' => '2024-01-25', 'content' => 'Eloquent là ORM của Laravel...'],
        ];

        if (!isset($allArticles[$id])) {
            abort(404, 'Bài viết không tồn tại');
        }

        $article = $allArticles[$id];
        return view('articles.edit', compact('article'));
    }


}