@extends('layouts.main')

@section('title', ($post->title ?? 'Blog') . ' | Di-tool')

@push('styles')
    <style>
        /* Blog article body (HTML from Summernote) — aligned with example.blade.php prose feel */
        .post-body {
            color: #334155;
            line-height: 1.75;
        }

        .post-body h1,
        .post-body h2,
        .post-body h3 {
            font-weight: 800;
            color: #0f172a;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .post-body h2 {
            font-size: 1.5rem;
        }

        .post-body h3 {
            font-size: 1.25rem;
        }

        .post-body p {
            margin-bottom: 1.5rem;
        }

        .post-body ul,
        .post-body ol {
            margin-bottom: 1.5rem;
            padding-left: 1.25rem;
        }

        .post-body ul {
            list-style-type: disc;
        }

        .post-body ol {
            list-style-type: decimal;
        }

        .post-body li {
            margin-bottom: 0.5rem;
        }

        .post-body a {
            color: #137fec;
            text-decoration: underline;
        }

        .post-body a:hover {
            color: #0f6ecd;
        }

        .post-body img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
        }

        .post-body pre {
            background: #0f172a;
            color: #f1f5f9;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .post-body code {
            background: #f1f5f9;
            color: #137fec;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .post-body pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        .post-body blockquote {
            border-left: 4px solid #137fec;
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #475569;
            font-size: 1.125rem;
        }

        /*
         * Tables from Summernote / CKEditor-style editors use <figure class="table">…</figure>.
         * You do NOT need Summernote CSS on the public site — only these display rules.
         */
        .post-body figure.table {
            display: block;
            width: 100%;
            max-width: 100%;
            margin: 1.5rem 0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .post-body figure.table table {
            width: 100%;
            min-width: 320px;
            border-collapse: collapse;
            border: 1px solid #cbd5e1;
            background: #fff;
            font-size: 0.9375rem;
        }

        .post-body table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            border: 1px solid #cbd5e1;
            background: #fff;
            font-size: 0.9375rem;
        }

        .post-body thead {
            background: rgba(19, 127, 236, 0.08);
        }

        .post-body th,
        .post-body td {
            border: 1px solid #cbd5e1;
            padding: 0.625rem 0.75rem;
            text-align: left;
            vertical-align: top;
        }

        .post-body th {
            font-weight: 700;
            color: #0f172a;
        }

        .post-body tbody tr:nth-child(even) {
            background: #f8fafc;
        }
    </style>
@endpush

@section('content')
    <div class="bg-[#f6f7f8] min-h-screen">
        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            {{-- Breadcrumbs (structure from example.blade.php) --}}
            <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                <a class="hover:text-[#137fec]" href="{{ route('home') }}">Home</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-slate-600">Blog</span>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-slate-900 line-clamp-1">{{ $post->title }}</span>
            </nav>

            <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
                <article class="lg:col-span-8">
                    <header class="mb-8">
                        <span
                            class="inline-flex items-center rounded-full bg-[#137fec]/10 px-3 py-1 text-xs font-bold text-[#137fec] mb-4 uppercase tracking-wider">Blog</span>
                        <h1 class="text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl mb-6">
                            {{ $post->title }}
                        </h1>
                        <div class="flex items-center gap-4 border-b border-slate-200 pb-8">
                            <div
                                class="h-12 w-12 rounded-full bg-slate-200 overflow-hidden flex items-center justify-center text-slate-500 font-bold">
                                {{ strtoupper(substr($post->author?->name ?? 'D', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $post->author?->name ?? 'Di-tool Team' }}</p>
                                <p class="text-xs text-slate-500">{{ $publishedLabel }} • {{ $readMinutes }} min read</p>
                            </div>
                        </div>
                    </header>

                    @if (filled($post->excerpt))
                        <p
                            class="text-lg text-slate-700 leading-relaxed mb-8 italic border-l-4 border-[#137fec] pl-6">
                            {{ $post->excerpt }}
                        </p>
                    @endif

                    <div class="post-body max-w-none mb-10">
                        {!! $post->content !!}
                    </div>

                    <div
                        class="mt-16 rounded-2xl bg-gradient-to-br from-[#137fec] to-blue-700 p-8 text-center text-white sm:p-12">
                        <h2 class="text-3xl font-black mb-4 text-white">Ready to boost your Inventor workflow?</h2>
                        <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">Explore Di-tool packages and stand-alone
                            tools for your team.</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center bg-white text-[#137fec] hover:bg-blue-50 font-bold py-4 px-8 rounded-xl transition-all shadow-lg">Back
                                to home</a>
                            <a href="{{ route('checkout') }}"
                                class="inline-flex items-center justify-center bg-blue-800/40 hover:bg-blue-800/60 border border-blue-400 text-white font-bold py-4 px-8 rounded-xl transition-all">Checkout</a>
                        </div>
                    </div>
                </article>

                <aside class="lg:col-span-4 space-y-10">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-6">Related articles</h3>
                        @if ($relatedPosts->isEmpty())
                            <p class="text-sm text-slate-500">No other posts yet.</p>
                        @else
                            <div class="space-y-6">
                                @foreach ($relatedPosts as $related)
                                    <a class="group flex gap-4"
                                        href="{{ route('post-detail', $related) }}">
                                        <div
                                            class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg bg-slate-100 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-slate-400">article</span>
                                        </div>
                                        <div>
                                            <h4
                                                class="text-sm font-bold text-slate-900 group-hover:text-[#137fec] transition-colors leading-snug line-clamp-2">
                                                {{ $related->title }}</h4>
                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $related->published_at?->format('M j, Y') ?? $related->updated_at->format('M j, Y') }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="bg-slate-900 p-6 rounded-xl text-white">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-[#137fec]">help</span>
                            <h3 class="text-sm font-bold uppercase tracking-widest">Help center</h3>
                        </div>
                        <p class="text-sm text-slate-300 mb-4">Browse guides and troubleshooting for Di-tool products.</p>
                        <a href="{{ route('help-center') }}"
                            class="inline-flex items-center text-xs font-bold text-[#137fec] hover:underline">
                            Open help center
                            <span class="material-symbols-outlined text-xs ml-1">arrow_forward</span>
                        </a>
                    </div>
                </aside>
            </div>
        </main>
    </div>
@endsection
