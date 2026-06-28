<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * before() – chạy TRƯỚC MỌI method khác trong Policy
     * Admin bypass tất cả
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true; // Admin bypass tất cả
        }
        return null; // null = tiếp tục check method cụ thể
    }

    /**
     * Xem danh sách bài viết: ai cũng xem được (kể cả guest)
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Xem chi tiết bài viết: published thì ai cũng xem, draft chỉ tác giả
     */
    public function view(?User $user, Post $post): bool
    {
        if ($post->status === 'published') {
            return true;
        }
        return $user?->id === $post->user_id;
    }

    /**
     * Tạo bài mới: phải đăng nhập
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Sửa bài: editor sửa được tất cả, user thường chỉ sửa của mình
     */
    public function update(User $user, Post $post): bool
    {
        // Editor (admin hoặc editor) được sửa tất cả bài
        if ($user->isEditor()) {
            return true;
        }
        // User thường: chỉ sửa bài của mình
        return $user->owns($post);
    }

    /**
     * Xóa bài: chỉ tác giả (admin đã bypass qua before)
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->owns($post);
    }

    /**
     * Khôi phục bài đã xóa mềm: chỉ tác giả
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->owns($post);
    }

    /**
     * Xóa vĩnh viễn: chỉ tác giả
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->owns($post);
    }
}