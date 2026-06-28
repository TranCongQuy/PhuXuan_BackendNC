<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Hiển thị danh sách bài viết
    public function index(Request $request)
    {
        // Dữ liệu giả (không dùng DB theo yêu cầu)
        $articles = [
            ['id' => 1, 'title' => 'Laravel 8: Những tính năng mới', 'category' => 'Công nghệ', 'content' => 'Laravel 8 giới thiệu nhiều cải tiến...', 'author' => 'Admin'],
            ['id' => 2, 'title' => 'Khám phá vũ trụ với James Webb', 'category' => 'Khoa học', 'content' => 'Kính viễn vọng James Webb đã gửi về...', 'author' => 'Admin'],
            ['id' => 3, 'title' => 'Xu hướng kinh doanh 2025', 'category' => 'Kinh doanh', 'content' => 'Các xu hướng kinh doanh nổi bật...', 'author' => 'Admin'],
            ['id' => 4, 'title' => 'Tối ưu hiệu suất Laravel', 'category' => 'Công nghệ', 'content' => 'Các mẹo tối ưu hiệu suất...', 'author' => 'Admin'],
            ['id' => 5, 'title' => 'Phát hiện mới về gene di truyền', 'category' => 'Khoa học', 'content' => 'Nghiên cứu mới về gene...', 'author' => 'Admin'],
            ['id' => 6, 'title' => 'Khởi nghiệp từ con số 0', 'category' => 'Kinh doanh', 'content' => 'Các bước khởi nghiệp cơ bản...', 'author' => 'Admin'],
        ];

        // Lọc theo category (query string)
        $category = $request->query('category');
        if ($category) {
            $articles = array_filter($articles, function ($article) use ($category) {
                return $article['category'] === $category;
            });
            // Reset keys
            $articles = array_values($articles);
        }

        $categories = ['Công nghệ', 'Khoa học', 'Kinh doanh'];

        return view('articles.index', compact('articles', 'categories', 'category'));
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