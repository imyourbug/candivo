<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'published_at',
        'user_id',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'order' => 'integer',
        ];
    }

    /**
     * First <img src="..."> in HTML content, for home cards when no dedicated image field exists.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', (string) $this->content, $m)) {
            return $m[1];
        }

        return null;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
