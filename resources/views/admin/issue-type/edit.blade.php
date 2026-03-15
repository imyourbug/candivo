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
        <form action="{{ route('admin.issue-types.update', $issueType) }}" method="post" class="p-6 md:p-8">
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
    <style>
        .cke_chrome { border-radius: 0.5rem !important; }
        .cke_top { border-radius: 0.5rem 0.5rem 0 0 !important; }
        .cke_bottom { border-radius: 0 0 0.5rem 0.5rem !important; }
        /* Hide CKEditor upgrade/security notification */
        .cke_notifications_area { display: none !important; }
    </style>
@endpush

@push('admin-scripts')
    <script src="https://cdn.jsdelivr.net/npm/ckeditor4@4.22.1/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var textarea = document.getElementById('issue-type-description');
            if (textarea && typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('issue-type-description', {
                    height: 220,
                    removePlugins: 'elementspath',
                    resize_enabled: true,
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                        { name: 'links', items: ['Link', 'Unlink'] },
                        { name: 'styles', items: ['Format', 'Styles'] },
                        { name: 'colors', items: ['TextColor', 'BGColor'] },
                        { name: 'tools', items: ['Maximize'] }
                    ],
                    on: {
                        instanceReady: function(ev) {
                            ev.editor.on('notificationShow', function(e) {
                                e.cancel();
                            }, null, null, 999);
                        }
                    }
                });
            }
        });
    </script>
@endpush
