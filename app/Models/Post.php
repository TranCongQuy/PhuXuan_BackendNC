<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// ✅ Import các Model liên quan
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'thumbnail',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'string',
    ];

    // Quan hệ với User (tác giả)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với Tags (nhiều-nhiều)
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // Quan hệ với Comments (1-nhiều)
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Lọc chỉ lấy comments đã được duyệt
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }
}