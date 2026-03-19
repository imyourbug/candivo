@extends('admin.layout')

@section('title', 'Users – Di-tool Admin')

@section('content')
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">User management</h2>
            <p class="text-slate-500 text-sm">Admin accounts that can sign in to this console.</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.users.index') }}" method="get" class="relative hidden sm:block">
                <input type="hidden" name="verified" value="{{ request('verified') }}" />
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                <input
                    name="search"
                    value="{{ request('search') }}"
                    class="pl-10 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none min-w-[240px]"
                    placeholder="Search name or email..."
                    type="text"
                />
            </form>
            <a href="{{ route('admin.users.create') }}"
                class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-bold shadow-sm transition-all">
                <span class="material-symbols-outlined text-lg">person_add</span>
                Add user
            </a>
        </div>
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-2">Total users</p>
            <h3 class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-2">Verified email</p>
            <h3 class="text-2xl font-bold">{{ $stats['verified'] ?? 0 }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-2">Unverified</p>
            <h3 class="text-2xl font-bold">{{ $stats['unverified'] ?? 0 }}</h3>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-3">
            <h3 class="font-bold text-lg">Accounts</h3>
            <form action="{{ route('admin.users.index') }}" method="get" class="flex items-center gap-2 flex-wrap">
                <input type="hidden" name="search" value="{{ request('search') }}" />
                <select name="verified" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                    <option value="">All</option>
                    <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified</option>
                    <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Unverified</option>
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api?name={{ urlencode($u->name) }}&background=e2e8f0&color=64748b" alt="" class="w-9 h-9 rounded-full" width="36" height="36" />
                                    <div>
                                        <div class="font-semibold text-slate-900 dark:text-white">{{ $u->name }}</div>
                                        @if($u->id === auth()->id())
                                            <span class="text-xs text-primary font-medium">You</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $u->email }}</td>
                            <td class="px-6 py-4">
                                @if($u->email_verified_at)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">Verified</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-slate-500/10 text-slate-500">Unverified</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">{{ $u->created_at->format('M j, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.users.edit', $u) }}" class="text-primary font-bold hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
