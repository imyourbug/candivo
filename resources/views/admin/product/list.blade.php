@extends('admin.layout')

@section('title', 'Product Management – Di-tool Admin')

@section('content')
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Product Management</h2>
            <p class="text-slate-500 text-sm">Manage your software inventory and sales performance.</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.products.index') }}" method="get" class="relative hidden sm:block">
                <input type="hidden" name="category_id" value="{{ request('category_id') }}" />
                <input type="hidden" name="status" value="{{ request('status') }}" />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    class="pl-10 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none min-w-[280px]"
                    placeholder="Search products..."
                    type="text"
                />
            </form>
            <a href="{{ route('admin.products.create') }}"
                class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-bold shadow-sm transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Add New Product
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Total Products</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg text-xl">inventory</span>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-2xl font-bold">{{ $products->total() }}</h3>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Active</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg text-xl">check_circle</span>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-2xl font-bold">{{ $stats['active'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Inactive</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg text-xl">cancel</span>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-2xl font-bold">{{ $stats['inactive'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Draft</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg text-xl">edit_note</span>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-2xl font-bold">{{ $stats['draft'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
            <h3 class="font-bold text-lg">Inventory Overview</h3>
            <form action="{{ route('admin.products.index') }}" method="get" class="flex items-center gap-2 flex-wrap">
                <input type="hidden" name="search" value="{{ request('search') }}" />
                <select name="category_id" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                    <option value="">All categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="status" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                    <option value="">All statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4 text-right">Price (1)</th>
                        <th class="px-6 py-4 text-right">Price (2)</th>
                        <th class="px-6 py-4 text-right">Price (3)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined">inventory_2</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 dark:text-white">{{ $product->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $product->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->category)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-medium">{{ $product->price_duration_1 ? '$' . number_format($product->price_duration_1, 2) : '—' }}</td>
                            <td class="px-6 py-4 text-right font-medium">{{ $product->price_duration_2 ? '$' . number_format($product->price_duration_2, 2) : '—' }}</td>
                            <td class="px-6 py-4 text-right font-medium">{{ $product->price_duration_3 ? '$' . number_format($product->price_duration_3, 2) : '—' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($product->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @elseif($product->status === 'inactive')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Inactive
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 text-slate-400 hover:text-primary transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="post" class="inline" onsubmit="return confirm('Delete this product?');">
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
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                No products found. <a href="{{ route('admin.products.create') }}" class="text-primary font-medium hover:underline">Create one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2">
                <span class="text-sm text-slate-500">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                </span>
                <div class="flex items-center gap-2">
                    @if ($products->onFirstPage())
                        <span class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-400 cursor-not-allowed">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                        </a>
                    @endif
                    @foreach ($products->getUrlRange(1, min(5, $products->lastPage())) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-[2rem] px-2 rounded-lg flex items-center justify-center text-sm font-medium {{ $products->currentPage() === $page ? 'bg-primary text-white' : 'border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="p-1.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800 transition-colors">
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
