<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            // Tham số 1: Rules
            [
                'title' => 'required|string|min:5|max:255',
                'content' => 'required|string|min:10',
            ],
            // Tham số 2: Custom Messages (tiếng Việt)
            [
                'title.required' => 'Tiêu đề bài viết không được để trống.',
                'title.min' => 'Tiêu đề phải có ít nhất :min ký tự.',
                'title.max' => 'Tiêu đề không được vượt quá :max ký tự.',
                'content.required' => 'Nội dung bài viết không được để trống.',
                'content.min' => 'Nội dung phải có ít nhất :min ký tự.',
            ]
        );

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => 1,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Tạo bài viết thành công!');
    }
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate(
            // Tham số 1: Rules
            [
                'title' => 'required|string|min:5|max:255',
                'content' => 'required|string|min:10',
            ],
            // Tham số 2: Custom Messages (tiếng Việt)
            [
                'title.required' => 'Tiêu đề bài viết không được để trống.',
                'title.min' => 'Tiêu đề phải có ít nhất :min ký tự.',
                'title.max' => 'Tiêu đề không được vượt quá :max ký tự.',
                'content.required' => 'Nội dung bài viết không được để trống.',
                'content.min' => 'Nội dung phải có ít nhất :min ký tự.',
            ]
        );

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
            ->with('success', 'Đã xóa bài viết.');
    }
}