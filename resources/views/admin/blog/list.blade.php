@extends('admin.layout')

@section('title', 'Blog Management – Di-tool Admin')

@section('content')
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Blog Management</h2>
            <p class="text-slate-500 text-sm">Create and manage blog posts.</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.posts.index') }}" method="get" class="relative hidden sm:block">
                <input type="hidden" name="status" value="{{ request('status') }}" />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    class="pl-10 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none min-w-[280px]"
                    placeholder="Search posts..."
                    type="text"
                />
            </form>
            <a href="{{ route('admin.posts.create') }}"
                class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-bold shadow-sm transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                New Post
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Total</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg text-xl">article</span>
            </div>
            <h3 class="text-2xl font-bold">{{ $posts->total() }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Published</p>
                <span class="material-symbols-outlined text-emerald-500 bg-emerald-500/10 p-2 rounded-lg text-xl">check_circle</span>
            </div>
            <h3 class="text-2xl font-bold">{{ $stats['published'] ?? 0 }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Drafts</p>
                <span class="material-symbols-outlined text-amber-500 bg-amber-500/10 p-2 rounded-lg text-xl">edit_note</span>
            </div>
            <h3 class="text-2xl font-bold">{{ $stats['draft'] ?? 0 }}</h3>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
            <h3 class="font-bold text-lg">Posts</h3>
            <form action="{{ route('admin.posts.index') }}" method="get" class="flex items-center gap-2">
                <input type="hidden" name="search" value="{{ request('search') }}" />
                <select name="status" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                    <option value="">All statuses</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Author</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Updated</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $post->title }}</p>
                                <p class="text-xs text-slate-500">{{ $post->slug }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $post->author?->name ?? $post->author?->email ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($post->status === 'published')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">Published</span>
                                @elseif($post->status === 'archived')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">Archived</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $post->updated_at->format('M j, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="p-1.5 text-slate-400 hover:text-primary transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="post" class="inline" onsubmit="return confirm('Delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 transition-colors" title="Delete">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                No posts yet. <a href="{{ route('admin.posts.create') }}" class="text-primary font-medium hover:underline">Create one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2">
                <span class="text-sm text-slate-500">
                    Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries
                </span>
                <div class="flex items-center gap-2">
                    @if ($posts->onFirstPage())
                        <span class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-400 cursor-not-allowed">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </a>
                    @endif
                    @foreach ($posts->getUrlRange(1, min(5, $posts->lastPage())) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-[2rem] px-2 rounded-lg flex items-center justify-center text-sm font-medium {{ $posts->currentPage() === $page ? 'bg-primary text-white' : 'border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                        </a>
                    @else
                        <span class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-400 cursor-not-allowed">
                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
