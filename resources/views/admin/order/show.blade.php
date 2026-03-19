@extends('admin.layout')

@section('title', 'Order '.$order->order_number.' – Di-tool Admin')

@section('content')
    <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-slate-500 hover:text-primary font-medium mb-2 inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Back to orders
            </a>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-mono">{{ $order->order_number }}</h2>
            <p class="text-slate-500 text-sm mt-1">Placed {{ $order->created_at->format('M j, Y \a\t H:i') }}</p>
        </div>
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
        <span class="inline-flex self-start px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $st }}">{{ $order->status }}</span>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 font-bold text-slate-800 dark:text-white">Line items</div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-3">Item</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3 text-center">Qty</th>
                                <th class="px-6 py-3 text-right">Unit</th>
                                <th class="px-6 py-3 text-right">Line total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900 dark:text-white">{{ $item->name }}</div>
                                        @if($item->period_label)
                                            <div class="text-xs text-slate-500">{{ $item->period_label }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 capitalize text-slate-600 dark:text-slate-400">{{ $item->entity_type }}</td>
                                    <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-right">{{ number_format((float) $item->unit_price, 2) }} {{ $item->currency }}</td>
                                    <td class="px-6 py-4 text-right font-medium">{{ number_format((float) $item->total_price, 2) }} {{ $item->currency }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 dark:text-white mb-4">Totals</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Subtotal</dt>
                        <dd class="font-medium">{{ number_format((float) $order->subtotal, 2) }} {{ $order->currency }}</dd>
                    </div>
                    @if((float) $order->discount > 0)
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Discount</dt>
                            <dd>−{{ number_format((float) $order->discount, 2) }}</dd>
                        </div>
                    @endif
                    @if((float) $order->tax > 0)
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Tax</dt>
                            <dd>{{ number_format((float) $order->tax, 2) }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between pt-2 border-t border-slate-200 dark:border-slate-700 text-lg font-bold">
                        <dt>Total</dt>
                        <dd>{{ number_format((float) $order->total, 2) }} {{ $order->currency }}</dd>
                    </div>
                </dl>
                @if($order->paid_at)
                    <p class="mt-4 text-xs text-slate-500">Paid {{ $order->paid_at->format('M j, Y H:i') }}</p>
                @endif
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 dark:text-white mb-4">Customer</h3>
                <dl class="space-y-2 text-sm">
                    <div>
                        <dt class="text-slate-500">Email</dt>
                        <dd class="font-medium break-all">{{ $order->email ?: '—' }}</dd>
                    </div>
                    @if($order->customer_name)
                        <div>
                            <dt class="text-slate-500">Name</dt>
                            <dd>{{ $order->customer_name }}</dd>
                        </div>
                    @endif
                    @if($order->address)
                        <div>
                            <dt class="text-slate-500">Country / address</dt>
                            <dd class="whitespace-pre-wrap">{{ $order->address }}</dd>
                        </div>
                    @endif
                    @if(is_array($order->metadata))
                        @if(!empty($order->metadata['country']))
                            <div>
                                <dt class="text-slate-500">Country (checkout)</dt>
                                <dd>{{ $order->metadata['country'] }}</dd>
                            </div>
                        @endif
                        @if(!empty($order->metadata['major']))
                            <div>
                                <dt class="text-slate-500">Major</dt>
                                <dd>{{ $order->metadata['major'] }}</dd>
                            </div>
                        @endif
                    @endif
                </dl>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 dark:text-white mb-4">Payment</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Method</dt>
                        <dd class="capitalize font-medium">{{ $order->payment_method ?: '—' }}</dd>
                    </div>
                    @if($order->payment_gateway_id)
                        <div>
                            <dt class="text-slate-500">Gateway reference</dt>
                            <dd class="font-mono text-xs break-all">{{ $order->payment_gateway_id }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 dark:text-white mb-4">Update status</h3>
                <form action="{{ route('admin.orders.update', $order) }}" method="post" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-500 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-2 focus:ring-primary">
                            <option value="{{ \App\Models\Order::STATUS_PENDING }}" {{ $order->status === \App\Models\Order::STATUS_PENDING ? 'selected' : '' }}>Pending</option>
                            <option value="{{ \App\Models\Order::STATUS_COMPLETED }}" {{ $order->status === \App\Models\Order::STATUS_COMPLETED ? 'selected' : '' }}>Completed</option>
                            <option value="{{ \App\Models\Order::STATUS_FAILED }}" {{ $order->status === \App\Models\Order::STATUS_FAILED ? 'selected' : '' }}>Failed</option>
                            <option value="{{ \App\Models\Order::STATUS_CANCELLED }}" {{ $order->status === \App\Models\Order::STATUS_CANCELLED ? 'selected' : '' }}>Cancelled</option>
                            <option value="{{ \App\Models\Order::STATUS_REFUNDED }}" {{ $order->status === \App\Models\Order::STATUS_REFUNDED ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    @error('status')
                        <p class="text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-2.5 rounded-lg text-sm transition-colors">
                        Save status
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
