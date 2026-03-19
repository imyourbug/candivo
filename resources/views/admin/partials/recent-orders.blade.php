@php
    $title = $title ?? 'Recent orders';
    $subtitle = $subtitle ?? 'Latest activity';
    $viewAllUrl = $viewAllUrl ?? route('admin.orders.index');
    $orders = $orders ?? collect();
    $totalOrderCount = $totalOrderCount ?? 0;
@endphp
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/30">
        <div>
            <h3 class="text-lg font-bold">{{ $title }}</h3>
            <p class="text-sm text-slate-500 font-medium">{{ $subtitle }}</p>
        </div>
        <a href="{{ $viewAllUrl }}" class="text-sm font-bold text-primary hover:underline">View all orders</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Order</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Customer</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($orders as $order)
                    @php
                        $status = $order->status ?? 'pending';
                        $statusClass = match ($status) {
                            'completed' => 'bg-green-500/10 text-green-500 border-green-500/20',
                            'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                            'cancelled', 'failed' => 'bg-red-500/10 text-red-500 border-red-500/20',
                            'refunded' => 'bg-violet-500/10 text-violet-500 border-violet-500/20',
                            default => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                        };
                        $customer = $order->customer_name ?: $order->email ?: '—';
                        $avatarName = urlencode($order->customer_name ?: $order->email ?: 'Customer');
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100 font-mono">
                            <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-primary">{{ $order->order_number }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden flex-shrink-0">
                                    <img alt="" src="https://ui-avatars.com/api?name={{ $avatarName }}&background=e2e8f0&color=64748b" class="w-full h-full object-cover" width="32" height="32" />
                                </div>
                                <div class="text-sm font-semibold truncate max-w-[12rem]">{{ $customer }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium whitespace-nowrap">{{ $order->created_at?->format('M j, Y H:i') ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm font-bold whitespace-nowrap">{{ number_format((float) $order->total, 2) }} {{ $order->currency }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusClass }}">{{ $status }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center text-sm font-bold text-primary hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                            No orders yet. They will appear here after checkout.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <p class="text-xs text-slate-500 font-medium">
            @if($totalOrderCount > 0)
                Showing {{ $orders->count() }} of {{ number_format($totalOrderCount) }} orders
            @else
                No orders in the database
            @endif
        </p>
    </div>
</section>
