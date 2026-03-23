<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'avatar',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'order' => 'integer',
        ];
    }

    /**
     * Public URL for the uploaded card avatar (`avatar` stores the storage path).
     */
    public function getAvatarUrlAttribute(): ?string
    {
        $path = $this->attributes['avatar'] ?? null;
        if (empty($path)) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * First image for home cards: uploaded avatar, else first &lt;img&gt; in HTML content.
     * Remote URLs from content are downscaled for small card slots.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! empty($this->attributes['avatar'] ?? null)) {
            return Storage::disk('public')->url($this->attributes['avatar']);
        }

        $head = substr((string) $this->content, 0, 12000);
        if (! preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $head, $m)) {
            return null;
        }

        return $this->thumbnailUrlForCard($m[1]);
    }

    /**
     * Plain-text preview for home cards without running strip_tags() on full post HTML.
     */
    public function getHomePreviewTextAttribute(): string
    {
        $excerpt = trim((string) $this->excerpt);
        if ($excerpt !== '') {
            return Str::limit(strip_tags($excerpt), 160);
        }

        $chunk = substr((string) $this->content, 0, 2500);

        return Str::limit(trim(strip_tags($chunk)), 160);
    }

    private function thumbnailUrlForCard(string $url): string
    {
        $url = html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (str_contains($url, 'images.unsplash.com')) {
            $url = preg_replace('/([?&])w=\d+/i', '$1w=480', $url) ?? $url;
            if (! preg_match('/[?&]w=\d+/i', $url)) {
                $url .= (str_contains($url, '?') ? '&' : '?').'auto=format&fit=crop&w=480&q=75';
            }
        }

        return $url;
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
