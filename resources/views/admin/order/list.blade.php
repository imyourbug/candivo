@extends('admin.layout')

@section('title', 'Orders – Di-tool Admin')

@section('content')
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Orders</h2>
            <p class="text-slate-500 text-sm">View and manage customer orders from checkout.</p>
        </div>
        <form action="{{ route('admin.orders.index') }}" method="get" class="flex flex-wrap items-center gap-2">
            <span class="material-symbols-outlined text-slate-400 hidden sm:inline">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Order #, email, name…"
                class="min-w-[200px] px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none" />
            <select name="status" onchange="this.form.submit()"
                class="text-sm border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-2 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                <option value="">All statuses</option>
                <option value="{{ \App\Models\Order::STATUS_PENDING }}" {{ request('status') === \App\Models\Order::STATUS_PENDING ? 'selected' : '' }}>Pending</option>
                <option value="{{ \App\Models\Order::STATUS_COMPLETED }}" {{ request('status') === \App\Models\Order::STATUS_COMPLETED ? 'selected' : '' }}>Completed</option>
                <option value="{{ \App\Models\Order::STATUS_FAILED }}" {{ request('status') === \App\Models\Order::STATUS_FAILED ? 'selected' : '' }}>Failed</option>
                <option value="{{ \App\Models\Order::STATUS_CANCELLED }}" {{ request('status') === \App\Models\Order::STATUS_CANCELLED ? 'selected' : '' }}>Cancelled</option>
                <option value="{{ \App\Models\Order::STATUS_REFUNDED }}" {{ request('status') === \App\Models\Order::STATUS_REFUNDED ? 'selected' : '' }}>Refunded</option>
            </select>
            <select name="payment_method" onchange="this.form.submit()"
                class="text-sm border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-2 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
                <option value="">All payments</option>
                <option value="{{ \App\Models\Order::PAYMENT_PAYPAL }}" {{ request('payment_method') === \App\Models\Order::PAYMENT_PAYPAL ? 'selected' : '' }}>PayPal</option>
                <option value="{{ \App\Models\Order::PAYMENT_MOLLIE }}" {{ request('payment_method') === \App\Models\Order::PAYMENT_MOLLIE ? 'selected' : '' }}>Mollie</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary/90">Filter</button>
        </form>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-1">Total orders</p>
            <h3 class="text-2xl font-bold">{{ number_format($stats['total']) }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-1">Completed</p>
            <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($stats['completed']) }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-1">Pending</p>
            <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ number_format($stats['pending']) }}</h3>
        </div>
        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-1">Revenue (completed)</p>
            <h3 class="text-2xl font-bold">{{ number_format($stats['revenue'], 2) }}</h3>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4 text-right">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-semibold text-slate-900 dark:text-white">{{ $order->order_number }}</span>
                                <span class="block text-xs text-slate-400">{{ $order->items_count }} {{ $order->items_count === 1 ? 'item' : 'items' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $order->email ?: '—' }}</div>
                                @if($order->customer_name)
                                    <div class="text-xs text-slate-500">{{ $order->customer_name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm capitalize">
                                {{ $order->payment_method ?: '—' }}
                            </td>
                            <td class="px-6 py-4 text-right font-semibold">
                                {{ number_format((float) $order->total, 2) }} {{ $order->currency }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusStyles = [
                                        'pending' => 'bg-amber-500/15 text-amber-700 dark:text-amber-400',
                                        'completed' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400',
                                        'failed' => 'bg-red-500/15 text-red-700 dark:text-red-400',
                                        'cancelled' => 'bg-slate-500/15 text-slate-600 dark:text-slate-400',
                                        'refunded' => 'bg-violet-500/15 text-violet-700 dark:text-violet-400',
                                    ];
                                    $st = $statusStyles[$order->status] ?? 'bg-slate-500/15 text-slate-600';
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $st }}">{{ $order->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                {{ $order->created_at->format('M j, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-primary font-semibold text-sm hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
