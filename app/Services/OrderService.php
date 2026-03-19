<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\SendOrderMailService;

class OrderService
{
    /**
     * Parse JSON cart data from the request into an array of cart items.
     *
     * @return array<int, array<string, mixed>>
     */
    public function parseCartData(?string $cartData): array
    {
        if ($cartData === null || $cartData === '') {
            return [];
        }
        $decoded = json_decode($cartData, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Create an order and order items from frontend cart data.
     */
    public function createOrderFromCart(
        array $cart,
        float $total,
        string $paymentMethod,
        string $currency = 'USD',
        array $customerData = []
    ): Order
    {
        $metadata = [
            'country' => $customerData['country'] ?? null,
            'major' => $customerData['major'] ?? null,
        ];

        $order = Order::create([
            'order_number' => $this->generateOrderNumber(),
            'email' => $customerData['email'] ?? null,
            'customer_name' => $customerData['name'] ?? null,
            'address' => $customerData['country'] ?? null,
            'subtotal' => $total,
            'discount' => 0,
            'tax' => 0,
            'total' => $total,
            'currency' => $currency,
            'payment_method' => $paymentMethod,
            'status' => Order::STATUS_PENDING,
            'metadata' => $metadata,
        ]);

        $subtotal = 0.0;
        foreach ($cart as $row) {
            $type = isset($row['type']) ? strtolower((string) $row['type']) : 'product';
            $rawId = $row['id'] ?? null;
            $entityId = $type === 'product'
                ? (int) str_replace('product-', '', (string) $rawId)
                : (int) $rawId;
            if ($entityId <= 0) {
                continue;
            }
            $name = $row['name'] ?? 'Item';
            $qty = max(1, (int) ($row['qty'] ?? 1));
            $unitPrice = round((float) ($row['price'] ?? 0), 2);
            $lineTotal = round($unitPrice * $qty, 2);
            $periodLabel = isset($row['period']) ? (string) $row['period'] : null;
            $durationMonths = null;
            if ($periodLabel !== null && $periodLabel !== '') {
                $trimmed = trim($periodLabel);
                if (preg_match('/^(\d+)\s*months?$/i', $trimmed, $m)) {
                    $durationMonths = (int) $m[1];
                } elseif (is_numeric($trimmed)) {
                    $durationMonths = (int) $trimmed;
                    $periodLabel = $durationMonths . ' months';
                }
            }

            $order->items()->create([
                'entity_type' => $type === 'package' ? OrderItem::ENTITY_PACKAGE : OrderItem::ENTITY_PRODUCT,
                'entity_id' => $entityId,
                'name' => $name,
                'duration_months' => $durationMonths,
                'period_label' => $periodLabel,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'total_price' => $lineTotal,
                'currency' => $currency,
            ]);
            $subtotal += $lineTotal;
        }

        $order->update(['subtotal' => round($subtotal, 2)]);

        return $order;
    }

    /**
     * Generate a unique order number.
     */
    public function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        $last = Order::query()
            ->where('order_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('order_number');

        $seq = 1;
        if ($last && preg_match('/-(\d+)$/', $last, $m)) {
            $seq = (int) $m[1] + 1;
        }

        return $prefix . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Mark the order as paid by id (from request, e.g. signed URL).
     * Returns true if the order was found and marked paid.
     */
    public function completeOrder(int $orderId, ?string $paymentGatewayId = null): bool
    {
        $order = Order::find($orderId);
        if (! $order) {
            return false;
        }

        if ($order->isPaid()) {
            return true;
        }

        $order->markAsPaid($paymentGatewayId);
        app(SendOrderMailService::class)->sendCheckoutSuccessMail($order);
        return true;
    }
}
