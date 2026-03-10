@extends('admin.layout')

@section('title', 'Dashboard Overview – Di-tool Admin')

@section('content')
    <!-- Welcome Section -->
    <section class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Dashboard Overview</h2>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Welcome back, here's what's happening with Di-tool today.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                <span class="material-symbols-outlined text-lg">calendar_today</span>
                <span>Last 30 Days</span>
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm hover:opacity-90 shadow-lg shadow-primary/20 transition-all">
                <span class="material-symbols-outlined text-lg">download</span>
                <span>Export Report</span>
            </button>
        </div>
    </section>

    <!-- Stat Cards Row -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-primary/10 rounded-lg text-primary">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <div class="flex items-center gap-1 text-green-500 text-sm font-bold bg-green-500/10 px-2 py-0.5 rounded-full">
                    <span class="material-symbols-outlined text-xs">trending_up</span>
                    <span>12.5%</span>
                </div>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-semibold uppercase tracking-wider mb-1">Total Sales</p>
            <h3 class="text-3xl font-bold">$128,430.00</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <p class="text-xs text-slate-400 font-medium">Compared to $114,160 last month</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-500/10 rounded-lg text-blue-500">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <div class="flex items-center gap-1 text-sm font-bold bg-primary/10 px-2 py-0.5 rounded-full text-[#137fec]">
                    <span class="material-symbols-outlined text-xs">pulse_alert</span>
                    <span>Active</span>
                </div>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-semibold uppercase tracking-wider mb-1">Active Users</p>
            <h3 class="text-3xl font-bold">14,201</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <div class="flex -space-x-2">
                    <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-900 bg-slate-300"></div>
                    <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-900 bg-slate-400"></div>
                    <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-900 bg-slate-500"></div>
                </div>
                <p class="text-xs text-slate-400 font-medium">+142 online right now</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-500/10 rounded-lg text-amber-500">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <div class="flex items-center gap-1 text-red-500 text-sm font-bold bg-red-500/10 px-2 py-0.5 rounded-full">
                    <span class="material-symbols-outlined text-xs">warning</span>
                    <span>High Priority</span>
                </div>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-semibold uppercase tracking-wider mb-1">Pending Orders</p>
            <h3 class="text-3xl font-bold">42</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <p class="text-xs text-slate-400 font-medium">8 orders delayed more than 24h</p>
            </div>
        </div>
    </section>

    <!-- Data Visualization Section -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold">Sales Velocity</h3>
                    <p class="text-sm text-slate-500 font-medium">Monitor performance across all tool categories</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-2 px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-md text-xs font-bold uppercase">
                        <span class="w-2 h-2 rounded-full bg-primary"></span> Current
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-md text-xs font-bold uppercase">
                        <span class="w-2 h-2 rounded-full bg-slate-300"></span> Previous
                    </div>
                </div>
            </div>
            <div class="h-64 flex items-end gap-3 w-full">
                <div class="flex-1 bg-slate-100 dark:bg-slate-800 rounded-t-lg relative group h-24 hover:bg-primary/20 transition-all">
                    <div class="absolute bottom-0 w-full bg-primary/40 h-2/3 rounded-t-lg"></div>
                    <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400">MON</div>
                </div>
                <div class="flex-1 bg-slate-100 dark:bg-slate-800 rounded-t-lg relative group h-36 hover:bg-primary/20 transition-all">
                    <div class="absolute bottom-0 w-full bg-primary/40 h-3/4 rounded-t-lg"></div>
                    <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400">TUE</div>
                </div>
                <div class="flex-1 bg-slate-100 dark:bg-slate-800 rounded-t-lg relative group h-28 hover:bg-primary/20 transition-all">
                    <div class="absolute bottom-0 w-full bg-primary/40 h-1/2 rounded-t-lg"></div>
                    <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400">WED</div>
                </div>
                <div class="flex-1 bg-slate-100 dark:bg-slate-800 rounded-t-lg relative group h-48 hover:bg-primary/20 transition-all">
                    <div class="absolute bottom-0 w-full bg-primary/40 h-4/5 rounded-t-lg"></div>
                    <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400">THU</div>
                </div>
                <div class="flex-1 bg-slate-100 dark:bg-slate-800 rounded-t-lg relative group h-44 hover:bg-primary/20 transition-all">
                    <div class="absolute bottom-0 w-full bg-primary/40 h-3/4 rounded-t-lg"></div>
                    <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400">FRI</div>
                </div>
                <div class="flex-1 bg-slate-100 dark:bg-slate-800 rounded-t-lg relative group h-56 hover:bg-primary/20 transition-all">
                    <div class="absolute bottom-0 w-full bg-primary/40 h-full rounded-t-lg"></div>
                    <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-primary">SAT</div>
                </div>
                <div class="flex-1 bg-slate-100 dark:bg-slate-800 rounded-t-lg relative group h-40 hover:bg-primary/20 transition-all">
                    <div class="absolute bottom-0 w-full bg-primary/40 h-2/3 rounded-t-lg"></div>
                    <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-slate-400">SUN</div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col">
            <h3 class="text-lg font-bold mb-6">Live Status</h3>
            <div class="space-y-6 flex-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
                        <span class="text-sm font-semibold">Payment Gateway</span>
                    </div>
                    <span class="text-[10px] font-bold text-green-500 uppercase">Operational</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
                        <span class="text-sm font-semibold">Inventory Sync</span>
                    </div>
                    <span class="text-[10px] font-bold text-green-500 uppercase">Operational</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                        <span class="text-sm font-semibold">Customer Support</span>
                    </div>
                    <span class="text-[10px] font-bold text-amber-500 uppercase">Busy</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span class="text-sm font-semibold">Logistics API</span>
                    </div>
                    <span class="text-[10px] font-bold text-green-500 uppercase">Operational</span>
                </div>
            </div>
            <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                <div class="bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <p class="text-xs text-slate-500 font-medium italic">Systems are scaling automatically based on current demand.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Orders Table -->
    @include('admin.partials.recent-orders')
@endsection
