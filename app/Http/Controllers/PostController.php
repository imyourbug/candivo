<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Show a published blog post by slug.
     */
    public function detail(Post $post): View
    {
        if (! $post->isPublished()) {
            abort(404);
        }

        $post->load('author');

        $relatedPosts = Post::query()
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->orderByDesc('updated_at')
            ->limit(4)
            ->get();

        $wordCount = str_word_count(strip_tags((string) ($post->content ?? '')));
        $readMinutes = max(1, (int) ceil($wordCount / 200));

        $publishedLabel = $post->published_at
            ? $post->published_at->format('M j, Y')
            : $post->updated_at->format('M j, Y');

        return view('post-detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'readMinutes' => $readMinutes,
            'publishedLabel' => $publishedLabel,
        ]);
    }
}
