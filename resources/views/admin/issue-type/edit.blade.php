@extends('admin.layout')

@section('title', 'Edit Issue Type – Di-tool Admin')

@section('content')
    <header class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.issue-types.index') }}" class="text-sm text-slate-500 hover:text-primary font-medium mb-2 inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Back to Issue Helper
            </a>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Edit Issue Type</h2>
            <p class="text-slate-500 text-sm">{{ $issueType->name }}</p>
        </div>
    </header>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden max-w-2xl">
        <form id="issue-type-form" action="{{ route('admin.issue-types.update', $issueType) }}" method="post" enctype="multipart/form-data" class="p-6 md:p-8" novalidate>
            @csrf
            @method('PUT')
            @include('admin.issue-type._form', ['issueType' => $issueType, 'parentOptions' => $parentOptions])
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center gap-3">
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Update Issue Type
                </button>
                <a href="{{ route('admin.issue-types.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@push('admin-styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor .note-editing-area .note-editable { min-height: 220px; }
    </style>
@endpush

@push('admin-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            var $textarea = $('#issue-type-description');
            if ($textarea.length && typeof $.fn.summernote === 'function') {
                $textarea.summernote({
                    height: 220,
                    tabsize: 2
                });
            }
        });
    </script>
@endpush
