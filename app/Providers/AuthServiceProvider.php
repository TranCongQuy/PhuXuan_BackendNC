<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate: kiểm tra quyền sửa bài viết (chỉ tác giả)
        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        // Gate: kiểm tra quyền xóa bài viết (tác giả hoặc admin)
        Gate::define('delete-post', function (User $user, Post $post) {
            // Admin (user_id = 1) được xóa mọi bài
            if ($user->id === 1) {
                return true;
            }
            return $user->id === $post->user_id;
        });
    }
}