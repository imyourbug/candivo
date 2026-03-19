<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard overview.
     */
    public function index(): View
    {
        $now = Carbon::now();
        $last30Start = $now->copy()->subDays(30);
        $prev30Start = $now->copy()->subDays(60);

        $revenueLast30 = (float) Order::query()
            ->where('status', Order::STATUS_COMPLETED)
            ->where('created_at', '>=', $last30Start)
            ->sum('total');

        $revenuePrev30 = (float) Order::query()
            ->where('status', Order::STATUS_COMPLETED)
            ->where('created_at', '>=', $prev30Start)
            ->where('created_at', '<', $last30Start)
            ->sum('total');

        $revenuePctChange = $revenuePrev30 > 0.0001
            ? round((($revenueLast30 - $revenuePrev30) / $revenuePrev30) * 100, 1)
            : ($revenueLast30 > 0 ? 100.0 : 0.0);

        $currency = Order::query()
            ->where('status', Order::STATUS_COMPLETED)
            ->whereNotNull('currency')
            ->latest('id')
            ->value('currency')
            ?? 'EUR';

        $totalOrders = Order::query()->count();

        $uniqueCustomers = Order::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->distinct()
            ->count('email');

        $pendingOrders = Order::query()
            ->where('status', Order::STATUS_PENDING)
            ->count();

        $pendingDelayed = Order::query()
            ->where('status', Order::STATUS_PENDING)
            ->where('created_at', '<', $now->copy()->subDay())
            ->count();

        $completedToday = Order::query()
            ->where('status', Order::STATUS_COMPLETED)
            ->whereDate('created_at', $now->toDateString())
            ->count();

        $dailyChart = [];
        $maxDay = 0.0;
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i)->startOfDay();
            $dayEnd = $day->copy()->endOfDay();
            $amount = (float) Order::query()
                ->where('status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$day, $dayEnd])
                ->sum('total');
            $maxDay = max($maxDay, $amount);
            $dailyChart[] = [
                'label' => $day->format('D'),
                'amount' => $amount,
            ];
        }
        $maxDay = $maxDay > 0 ? $maxDay : 1.0;
        foreach ($dailyChart as &$row) {
            $row['height_pct'] = (int) round(($row['amount'] / $maxDay) * 100);
        }
        unset($row);

        $recentOrders = Order::query()
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'revenue_last_30' => $revenueLast30,
            'revenue_prev_30' => $revenuePrev30,
            'revenue_pct_change' => $revenuePctChange,
            'currency' => $currency,
            'total_orders' => $totalOrders,
            'unique_customers' => $uniqueCustomers,
            'pending_orders' => $pendingOrders,
            'pending_delayed' => $pendingDelayed,
            'completed_today' => $completedToday,
        ];

        $catalog = [
            'products' => Product::query()->count(),
            'posts' => Post::query()->count(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'dailyChart',
            'recentOrders',
            'catalog'
        ));
    }
}
