@php
    $title = $title ?? 'Recent Orders';
    $subtitle = $subtitle ?? 'Last 5 transactions processed in the last 24h';
    $viewAllUrl = $viewAllUrl ?? '#';
    $orders = $orders ?? [];
@endphp
<section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/30">
        <div>
            <h3 class="text-lg font-bold">{{ $title }}</h3>
            <p class="text-sm text-slate-500 font-medium">{{ $subtitle }}</p>
        </div>
        <a href="{{ $viewAllUrl }}" class="text-sm font-bold text-primary hover:underline">View All Orders</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Order ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Customer</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100">{{ $order['id'] ?? $order['order_number'] ?? '#' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                                    <img alt="Customer" src="{{ $order['avatar'] ?? 'https://ui-avatars.com/api?name=' . urlencode($order['customer'] ?? 'User') }}" class="w-full h-full object-cover" />
                                </div>
                                <div class="text-sm font-semibold">{{ $order['customer'] ?? '—' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $order['date'] ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm font-bold">{{ $order['amount'] ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @php $status = $order['status'] ?? 'pending'; $statusClass = match($status) { 'completed', 'paid' => 'bg-green-500/10 text-green-500 border-green-500/20', 'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20', 'cancelled', 'failed' => 'bg-red-500/10 text-red-500 border-red-500/20', default => 'bg-blue-500/10 text-blue-500 border-blue-500/20' }; @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusClass }}">{{ $status }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </td>
                    </tr>
                @empty
                    {{-- Placeholder rows when no data --}}
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100">#TR-8921</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                                    <img alt="Customer" src="https://ui-avatars.com/api?name=John+Doe" class="w-full h-full object-cover" />
                                </div>
                                <div class="text-sm font-semibold">Johnathan Doe</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">Oct 24, 2023 09:12 AM</td>
                        <td class="px-6 py-4 text-sm font-bold">$1,240.00</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-green-500/10 text-green-500 text-[10px] font-bold uppercase tracking-wider border border-green-500/20">Completed</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100">#TR-8922</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                                    <img alt="Customer" src="https://ui-avatars.com/api?name=Sarah+Connor" class="w-full h-full object-cover" />
                                </div>
                                <div class="text-sm font-semibold">Sarah Connor</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">Oct 24, 2023 10:45 AM</td>
                        <td class="px-6 py-4 text-sm font-bold">$540.00</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase tracking-wider border border-amber-500/20">Pending</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100">#TR-8923</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                                    <img alt="Customer" src="https://ui-avatars.com/api?name=Marcus+A" class="w-full h-full object-cover" />
                                </div>
                                <div class="text-sm font-semibold">Marcus Aurelius</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">Oct 24, 2023 11:30 AM</td>
                        <td class="px-6 py-4 text-sm font-bold">$2,100.00</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-green-500/10 text-green-500 text-[10px] font-bold uppercase tracking-wider border border-green-500/20">Completed</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group">
                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100">#TR-8924</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                                    <img alt="Customer" src="https://ui-avatars.com/api?name=Lina+I" class="w-full h-full object-cover" />
                                </div>
                                <div class="text-sm font-semibold">Lina Inverse</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">Oct 24, 2023 12:15 PM</td>
                        <td class="px-6 py-4 text-sm font-bold">$89.00</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-red-500/10 text-red-500 text-[10px] font-bold uppercase tracking-wider border border-red-500/20">Cancelled</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer group border-b-0">
                        <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-slate-100">#TR-8925</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden flex-shrink-0">
                                    <img alt="Customer" src="https://ui-avatars.com/api?name=Robert+B" class="w-full h-full object-cover" />
                                </div>
                                <div class="text-sm font-semibold">Robert Baratheon</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">Oct 24, 2023 01:50 PM</td>
                        <td class="px-6 py-4 text-sm font-bold">$3,420.00</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-500 text-[10px] font-bold uppercase tracking-wider border border-blue-500/20">Processing</span>
                        </td>
                        <td class="px-6 py-4 text-slate-400 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
        <p class="text-xs text-slate-500 font-medium">Showing {{ count($orders) ?: 5 }} of {{ $total ?? '1,280' }} orders</p>
        <div class="flex gap-2">
            <button type="button" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded disabled:opacity-30" disabled>
                <span class="material-symbols-outlined text-xl">chevron_left</span>
            </button>
            <button type="button" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded">
                <span class="material-symbols-outlined text-xl">chevron_right</span>
            </button>
        </div>
    </div>
</section>
