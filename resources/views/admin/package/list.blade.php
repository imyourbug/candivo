@extends('admin.layout')

@section('title', 'Package Management – Di-tool Admin')

@section('content')
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Package Management</h2>
            <p class="text-slate-500 text-sm">Manage package catalog, linked products, and pricing tiers.</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.packages.index') }}" method="get" class="relative hidden sm:block">
                <input type="hidden" name="type_code" value="{{ request('type_code') }}" />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    class="pl-10 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none min-w-[280px]"
                    placeholder="Search packages..."
                    type="text"
                />
            </form>
            <a href="{{ route('admin.packages.create') }}"
                class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-bold shadow-sm transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Add New Package
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
            <h3 class="font-bold text-lg">Packages</h3>
            <form action="{{ route('admin.packages.index') }}" method="get" class="flex items-center gap-2">
                <input type="hidden" name="search" value="{{ request('search') }}" />
                <select name="type_code" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                    <option value="">All types</option>
                    @foreach($types as $type)
                        <option value="{{ $type->code }}" {{ request('type_code') === $type->code ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4 text-right">Products</th>
                        <th class="px-6 py-4 text-right">Pricing tiers</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($packages as $package)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $package->name }}</p>
                                <p class="text-xs text-slate-500">{{ $package->slug }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $package->type?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-slate-600 dark:text-slate-400">
                                {{ $package->products_count }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-slate-600 dark:text-slate-400">
                                {{ $package->pricing_count }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.packages.edit', $package) }}" class="p-1.5 text-slate-400 hover:text-primary transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="post" class="inline" onsubmit="return confirm('Delete this package?');">
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
                                No packages found. <a href="{{ route('admin.packages.create') }}" class="text-primary font-medium hover:underline">Create one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
