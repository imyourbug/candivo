@extends('admin.layout')

@section('title', 'Dashboard Overview – Di-tool Admin')

@section('content')
    @php
        $c = $stats['currency'] ?? 'EUR';
        $fmt = fn ($n) => number_format((float) $n, 2);
        $pct = $stats['revenue_pct_change'] ?? 0;
        $pctUp = $pct > 0;
        $pctDown = $pct < 0;
    @endphp
    <!-- Welcome Section -->
    <section class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Dashboard Overview</h2>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Welcome back — sales and orders from your database.</p>
        </div>
        <div class="flex gap-3">
            <span class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg font-semibold text-sm text-slate-600 dark:text-slate-300"
                title="Revenue and comparison use completed orders in rolling 30-day windows">
                <span class="material-symbols-outlined text-lg">calendar_today</span>
                <span>Last 30 days</span>
            </span>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm hover:opacity-90 shadow-lg shadow-primary/20 transition-all">
                <span class="material-symbols-outlined text-lg">receipt_long</span>
                <span>View orders</span>
            </a>
        </div>
    </section>

    <!-- Stat Cards Row -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-primary/10 rounded-lg text-primary">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <div class="flex items-center gap-1 text-sm font-bold px-2 py-0.5 rounded-full
                    {{ $pctUp ? 'text-green-600 bg-green-500/10' : ($pctDown ? 'text-rose-600 bg-rose-500/10' : 'text-slate-500 bg-slate-500/10') }}">
                    @if($pctUp)
                        <span class="material-symbols-outlined text-xs">trending_up</span>
                    @elseif($pctDown)
                        <span class="material-symbols-outlined text-xs">trending_down</span>
                    @else
                        <span class="material-symbols-outlined text-xs">horizontal_rule</span>
                    @endif
                    <span>{{ $pct > 0 ? '+' : '' }}{{ $fmt($pct) }}%</span>
                </div>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-semibold uppercase tracking-wider mb-1">Revenue (30 days)</p>
            <h3 class="text-3xl font-bold">{{ $fmt($stats['revenue_last_30'] ?? 0) }} {{ $c }}</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <p class="text-xs text-slate-400 font-medium">Previous 30 days: {{ $fmt($stats['revenue_prev_30'] ?? 0) }} {{ $c }} (completed orders)</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-500/10 rounded-lg text-blue-500">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <div class="flex items-center gap-1 text-sm font-bold bg-primary/10 px-2 py-0.5 rounded-full text-[#137fec]">
                    <span class="material-symbols-outlined text-xs">mail</span>
                    <span>Distinct emails</span>
                </div>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-semibold uppercase tracking-wider mb-1">Unique customers</p>
            <h3 class="text-3xl font-bold">{{ number_format($stats['unique_customers'] ?? 0) }}</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <p class="text-xs text-slate-400 font-medium">{{ number_format($stats['total_orders'] ?? 0) }} total orders in the system</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-500/10 rounded-lg text-amber-500">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                @if(($stats['pending_delayed'] ?? 0) > 0)
                    <div class="flex items-center gap-1 text-red-500 text-sm font-bold bg-red-500/10 px-2 py-0.5 rounded-full">
                        <span class="material-symbols-outlined text-xs">warning</span>
                        <span>Needs attention</span>
                    </div>
                @else
                    <div class="flex items-center gap-1 text-emerald-600 text-sm font-bold bg-emerald-500/10 px-2 py-0.5 rounded-full">
                        <span class="material-symbols-outlined text-xs">check_circle</span>
                        <span>On track</span>
                    </div>
                @endif
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-semibold uppercase tracking-wider mb-1">Pending orders</p>
            <h3 class="text-3xl font-bold">{{ number_format($stats['pending_orders'] ?? 0) }}</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <p class="text-xs text-slate-400 font-medium">
                    @if(($stats['pending_delayed'] ?? 0) > 0)
                        {{ $stats['pending_delayed'] }} pending over 24 hours
                    @else
                        No pending orders older than 24 hours
                    @endif
                </p>
            </div>
        </div>
    </section>

    <!-- Data Visualization Section -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold">Completed revenue</h3>
                    <p class="text-sm text-slate-500 font-medium">Last 7 days ({{ $c }})</p>
                </div>
            </div>
            <div class="flex items-end gap-3 w-full pb-6">
                @foreach($dailyChart as $day)
                    @php
                        $h = max(6, (int) ($day['height_pct'] ?? 0));
                    @endphp
                    <div class="flex-1 flex flex-col justify-end min-w-0">
                        <div class="relative w-full h-48 rounded-t-lg bg-slate-100 dark:bg-slate-800 group overflow-hidden">
                            <div class="absolute bottom-0 left-0 right-0 bg-primary/50 rounded-t-lg transition-all group-hover:bg-primary/70"
                                style="height: {{ $h }}%"></div>
                        </div>
                        <div class="text-center mt-2 text-[10px] font-bold text-slate-400">{{ $day['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col">
            <h3 class="text-lg font-bold mb-6">At a glance</h3>
            <div class="space-y-6 flex-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-sm font-semibold">Completed today</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200 tabular-nums">{{ number_format($stats['completed_today'] ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary"></div>
                        <span class="text-sm font-semibold">Products</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200 tabular-nums">{{ number_format($catalog['products'] ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-violet-500"></div>
                        <span class="text-sm font-semibold">Blog posts</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200 tabular-nums">{{ number_format($catalog['posts'] ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <span class="text-sm font-semibold">Pending orders</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200 tabular-nums">{{ number_format($stats['pending_orders'] ?? 0) }}</span>
                </div>
            </div>
            <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-800">
                <div class="bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <p class="text-xs text-slate-500 font-medium">Revenue counts only orders with status <span class="font-semibold">completed</span>.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Orders Table -->
    @include('admin.partials.recent-orders', [
        'orders' => $recentOrders,
        'totalOrderCount' => $stats['total_orders'] ?? 0,
        'viewAllUrl' => route('admin.orders.index'),
    ])
@endsection
