<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()
            ->with(['user:id,name', 'category:id,name', 'tags:id,name'])
            ->withCount('comments');

        if ($request->has('mine') && $request->mine == 1) {
            $query->where('user_id', Auth::id());
        } else {
            if (!Auth::check() || Auth::id() != 1) {
                $query->published();
            }
        }

        $query->when($request->search, function ($q, $search) {
            $q->where('title', 'like', "%{$search}%");
        })
            ->when($request->category_id, function ($q, $categoryId) {
                $q->ofCategory($categoryId);
            })
            ->when($request->sort === 'popular', function ($q) {
                $q->popular();
            }, function ($q) {
                $q->latest('published_at');
            });

        $posts = $query->paginate(10)->appends($request->query());
        $categories = Category::select('id', 'name')->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = Auth::id();

        Post::create($data);

        return redirect()->route('posts.index')
            ->with('success', 'Tạo bài viết thành công!');
    }

    public function show(Post $post)
    {
        $post->load(['approvedComments.user', 'tags']);
        $post->loadCount('comments');

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        $post->update($data);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        // SỬA: quay về danh sách bài viết của user (mine=1)
        return redirect()->route('posts.index', ['mine' => 1])
            ->with('success', 'Đã xóa bài viết!');
    }

    public function trashed(Request $request)
    {
        $query = Post::onlyTrashed()->latest('deleted_at');

        // Nếu không phải admin, chỉ xem bài của mình
        if (Auth::id() != 1) {
            $query->where('user_id', Auth::id());
        }

        $posts = $query->paginate(10);
        return view('posts.trashed', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        // SỬA: quay về trang thùng rác (giữ mine=1 để quay lại đúng)
        return redirect()->route('posts.trashed', ['mine' => 1])
            ->with('success', 'Đã khôi phục bài viết!');
    }

    public function publish(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Bài viết đã được xuất bản.');
    }
}