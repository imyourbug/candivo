<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * List orders with filters.
     */
    public function index(Request $request): View
    {
        $query = Order::query()->withCount('items')->latest();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('order_number', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('customer_name', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Order::count(),
            'completed' => Order::where('status', Order::STATUS_COMPLETED)->count(),
            'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
            'revenue' => (float) Order::where('status', Order::STATUS_COMPLETED)->sum('total'),
        ];

        return view('admin.order.list', compact('orders', 'stats'));
    }

    /**
     * Order detail with line items.
     */
    public function show(Order $order): View
    {
        $order->load(['items' => function ($q) {
            $q->orderBy('id');
        }]);

        return view('admin.order.show', compact('order'));
    }

    /**
     * Update order status (e.g. cancel / refund).
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:'.Order::STATUS_PENDING.','.Order::STATUS_COMPLETED.','.Order::STATUS_FAILED.','.Order::STATUS_CANCELLED.','.Order::STATUS_REFUNDED,
            ],
        ], [
            'status.required' => 'Please select a status.',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order status updated.');
    }
}
