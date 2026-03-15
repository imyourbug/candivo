@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp
<aside class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col">
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white">
            <span class="material-symbols-outlined text-2xl">construction</span>
        </div>
        <div>
            <h1 class="font-bold text-lg leading-none">Di-tool</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Admin Console</p>
        </div>
    </div>
    <nav class="flex-1 px-4 py-4 space-y-1">
        <a class="{{ $currentRoute === 'admin.dashboard' ? 'active-sidebar-item text-primary font-semibold' : 'sidebar-item text-slate-600 dark:text-slate-300 font-medium' }} flex items-center gap-3 px-3 py-3 rounded-lg transition-colors"
            href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="{{ in_array($currentRoute, ['admin.products.index', 'admin.products.create', 'admin.products.edit']) ? 'active-sidebar-item text-primary font-semibold' : 'sidebar-item text-slate-600 dark:text-slate-300 font-medium' }} flex items-center gap-3 px-3 py-3 rounded-lg transition-colors"
            href="{{ route('admin.products.index') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span>Products</span>
        </a>
        <a class="{{ in_array($currentRoute, ['admin.posts.index', 'admin.posts.create', 'admin.posts.edit']) ? 'active-sidebar-item text-primary font-semibold' : 'sidebar-item text-slate-600 dark:text-slate-300 font-medium' }} flex items-center gap-3 px-3 py-3 rounded-lg transition-colors"
            href="{{ route('admin.posts.index') }}">
            <span class="material-symbols-outlined">article</span>
            <span>Blog</span>
        </a>
        <a class="{{ in_array($currentRoute, ['admin.issue-types.index', 'admin.issue-types.create', 'admin.issue-types.edit']) ? 'active-sidebar-item text-primary font-semibold' : 'sidebar-item text-slate-600 dark:text-slate-300 font-medium' }} flex items-center gap-3 px-3 py-3 rounded-lg transition-colors"
            href="{{ route('admin.issue-types.index') }}">
            <span class="material-symbols-outlined">help</span>
            <span>Issue Helper</span>
        </a>
        <a class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-slate-300 font-medium transition-colors"
            href="#">
            <span class="material-symbols-outlined">auto_awesome_motion</span>
            <span>Combos</span>
        </a>
        <a class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-slate-300 font-medium transition-colors"
            href="#">
            <span class="material-symbols-outlined">bar_chart</span>
            <span>Sales</span>
        </a>
        <a class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-slate-300 font-medium transition-colors"
            href="#">
            <span class="material-symbols-outlined">group</span>
            <span>Users</span>
        </a>
        <div class="pt-10 pb-2 px-3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Configuration</p>
        </div>
        <a class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-slate-300 font-medium transition-colors"
            href="#">
            <span class="material-symbols-outlined">settings</span>
            <span>Settings</span>
        </a>
    </nav>
    <div class="p-4 border-t border-slate-200 dark:border-slate-800">
        <form method="POST" action="{{ route('admin.logout') }}" class="block">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-3 w-full rounded-lg text-slate-600 dark:text-slate-300 font-medium hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
