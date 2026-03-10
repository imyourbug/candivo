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
        <form action="{{ route('admin.posts.update', $post) }}" method="post" class="p-6 md:p-8" id="blog-form">
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
    <style>
        .ck.ck-editor { width: 100%; }
        .ck.ck-editor .ck-editor__editable { min-height: 280px; }
    </style>
    @endpush
    @push('admin-scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor.create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
            }).catch(function(err) { console.error(err); });
        });
    </script>
    @endpush
@endsection
