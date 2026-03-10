@extends('admin.layout')

@section('title', 'Add Product – Di-tool Admin')

@section('content')
    <header class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-slate-500 hover:text-primary font-medium mb-2 inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Back to products
            </a>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Add New Product</h2>
            <p class="text-slate-500 text-sm">Create a new product in your inventory.</p>
        </div>
    </header>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden max-w-4xl">
        <form action="{{ route('admin.products.store') }}" method="post" class="p-6 md:p-8">
            @csrf
            @include('admin.product._form', ['product' => null, 'categories' => $categories])
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center gap-3">
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-xl">add</span>
                    Create Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
