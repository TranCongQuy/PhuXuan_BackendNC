<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Str;

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

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = 1; // tạm thời hardcode

        Post::create($data);

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

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']); // cập nhật slug khi title thay đổi

        $post->update($data);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(Post $post)
    {
        $title = $post->title;
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Đã xóa bài viết: ' . $title);
    }
}