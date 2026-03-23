@extends('admin.layout')

@section('title', 'Edit Post – Di-tool Admin')

@section('content')
    <header class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.posts.index') }}" class="text-sm text-slate-500 hover:text-primary font-medium mb-2 inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Back to blog
            </a>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Post</h2>
            <p class="text-slate-500 text-sm">{{ $post->title }}</p>
        </div>
    </header>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden max-w-4xl">
        <form action="{{ route('admin.posts.update', $post) }}" method="post" enctype="multipart/form-data" class="p-6 md:p-8" id="blog-form" novalidate>
            @csrf
            @method('PUT')
            @include('admin.blog._form', ['post' => $post])
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center gap-3">
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Update Post
                </button>
                <a href="{{ route('admin.posts.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    @push('admin-styles')
    {{-- Use summernote-lite to avoid Bootstrap CSS overriding admin font sizes --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor .note-editing-area .note-editable {
            min-height: 280px;
        }
    </style>
    @endpush
    @push('admin-scripts')
    {{-- jQuery loads in admin layout before this stack --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            const $form = $('#blog-form');
            const $title = $('#title');
            const $status = $('#status');
            const $content = $('#content');

            function setBlogErr($field, msg) {
                $field.toggleClass('border-rose-500', !!msg);
                let $p = $field.siblings('.js-blog-client-error');
                if (!$p.length) {
                    $p = $('<p class="js-blog-client-error text-sm text-rose-500 mt-1"></p>');
                    $field.after($p);
                }
                $p.text(msg || '');
                if (!msg) { $p.remove(); }
            }

            function validateBlogForm() {
                var ok = true;
                var title = ($title.val() || '').trim();
                if (!title) {
                    setBlogErr($title, 'Title is required.');
                    ok = false;
                } else {
                    setBlogErr($title, '');
                }
                var status = ($status.val() || '').trim();
                if (!status) {
                    setBlogErr($status, 'Please select a status.');
                    ok = false;
                } else {
                    setBlogErr($status, '');
                }
                return ok;
            }

            if ($content.length && typeof $.fn.summernote === 'function') {
                $content.summernote({
                    height: 280,
                    tabsize: 2
                });
            }

            $title.on('input blur', function() {
                var v = ($title.val() || '').trim();
                setBlogErr($title, v ? '' : 'Title is required.');
            });
            $status.on('change blur', function() {
                var v = ($status.val() || '').trim();
                setBlogErr($status, v ? '' : 'Please select a status.');
            });

            $form.on('submit', function(e) {
                if (!validateBlogForm()) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
    @endpush
@endsection
