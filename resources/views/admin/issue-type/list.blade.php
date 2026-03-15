@extends('admin.layout')

@section('title', 'Issue Helper Management – Di-tool Admin')

@section('content')
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Issue Helper Management</h2>
            <p class="text-slate-500 text-sm">Manage issue types shown as a tree in the Help Center sidebar.</p>
        </div>
        <a href="{{ route('admin.issue-types.create') }}"
            class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-bold shadow-sm transition-all">
            <span class="material-symbols-outlined text-lg">add</span>
            Add Issue Type
        </a>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Total issue types</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg text-xl">folder</span>
            </div>
            <h3 class="text-2xl font-bold">{{ $total ?? 0 }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm font-medium">Root categories</p>
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg text-xl">category</span>
            </div>
            <h3 class="text-2xl font-bold">{{ $roots ?? 0 }}</h3>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800">
            <h3 class="font-bold text-lg">Issue types tree</h3>
            <p class="text-slate-500 text-sm mt-1">This tree is shown in the Help Center sidebar on the client side.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4 text-right">Sort</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($tree as $node)
                        @include('admin.issue-type._row', ['node' => $node, 'depth' => 0])
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                No issue types yet. <a href="{{ route('admin.issue-types.create') }}" class="text-primary font-medium hover:underline">Add one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
