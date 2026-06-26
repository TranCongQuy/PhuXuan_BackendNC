<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'category_id',
        'user_id',
        'thumbnail',
        'status',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'string',
        'views_count' => 'integer',
    ];

    // ─── LOCAL SCOPES ────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->orderByDesc('views_count');
    }

    public function scopeRecent(Builder $query, int $days = 7): Builder
    {
        return $query->where('published_at', '>=', now()->subDays($days));
    }

    public function scopeOfCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    // ─── ACCESSOR (Cách viết cũ, tương thích PHP 7.4) ──────

    public function getReadingTimeAttribute()
    {
        $content = $this->content ?? '';
        $wordCount = str_word_count(strip_tags($content));
        $minutes = (int) ceil($wordCount / 200);
        return max(1, $minutes) . ' phút đọc';
    }

    // ─── RELATIONSHIPS ──────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }
}