@extends('admin.layout')

@section('title', 'Add Package – Di-tool Admin')

@section('content')
    <header class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.packages.index') }}" class="text-sm text-slate-500 hover:text-primary font-medium mb-2 inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Back to packages
            </a>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Add New Package</h2>
            <p class="text-slate-500 text-sm">Create a package and assign products/pricing.</p>
        </div>
    </header>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden max-w-5xl">
        <form id="admin-package-form" action="{{ route('admin.packages.store') }}" method="post" class="p-6 md:p-8" novalidate>
            @csrf
            @include('admin.package._form', ['package' => null, 'types' => $types, 'products' => $products])
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center gap-3">
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-xl">add</span>
                    Create Package
                </button>
                <a href="{{ route('admin.packages.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
