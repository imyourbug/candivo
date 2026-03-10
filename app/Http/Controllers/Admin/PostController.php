<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::query()->with('author');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%")
                    ->orWhere('excerpt', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->paginate(15)->withQueryString();
        $stats = [
            'draft' => Post::where('status', 'draft')->count(),
            'published' => Post::where('status', 'published')->count(),
            'archived' => Post::where('status', 'archived')->count(),
        ];

        return view('admin.blog.list', compact('posts', 'stats'));
    }

    public function create(): View
    {
        return view('admin.blog.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validatePost($request, $post);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    private function validatePost(Request $request, ?Post $post = null): array
    {
        $slugRule = ['nullable', 'string', 'max:255'];
        if ($post) {
            $slugRule[] = 'unique:posts,slug,' . $post->id;
        } else {
            $slugRule[] = 'unique:posts,slug';
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => $slugRule,
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:draft,published,archived'],
        ], [
            'title.required' => 'Title is required.',
            'slug.unique' => 'This URL slug is already in use.',
        ]);
    }
}
