<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment; // 👈 THÊM
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

        return redirect()->route('posts.index', ['mine' => 1])
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

        return redirect()->route('posts.index', ['mine' => 1])
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index', ['mine' => 1])
            ->with('success', 'Đã xóa bài viết!');
    }

    public function trashed(Request $request)
    {
        $query = Post::onlyTrashed()->latest('deleted_at');

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

        return redirect()->route('posts.trashed', ['mine' => 1])
            ->with('success', 'Đã khôi phục bài viết!');
    }

    public function publish(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('posts.index', ['mine' => 1])
            ->with('success', 'Bài viết đã được xuất bản!');
    }

    // 👇 COMMENT METHODS
    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|min:3|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'is_approved' => true,
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Bình luận của bạn đã được đăng!');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::id() !== 1) {
            abort(403, 'Bạn không có quyền sửa bình luận này.');
        }

        $request->validate([
            'body' => 'required|min:3|max:1000',
        ]);

        $comment->update(['body' => $request->body]);

        return redirect()->route('posts.show', $comment->post_id)
            ->with('success', 'Bình luận đã được cập nhật.');
    }

    public function destroyComment(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::id() !== 1) {
            abort(403, 'Bạn không có quyền xóa bình luận này.');
        }

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('posts.show', $postId)
            ->with('success', 'Bình luận đã được xóa.');
    }
}