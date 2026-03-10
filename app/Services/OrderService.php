<?php

namespace App\Services;

use App\Models\Order;

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
    public function createOrderFromCart(array $cart, float $total, string $paymentMethod, string $currency = 'USD'): Order
    {
        return Order::createFromCart($cart, $total, $paymentMethod, $currency);
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
        $order->markAsPaid($paymentGatewayId);
        return true;
    }
}
