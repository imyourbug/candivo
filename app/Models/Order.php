<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_REFUNDED = 'refunded';

    public const PAYMENT_PAYPAL = 'paypal';

    public const PAYMENT_MOLLIE = 'mollie';

    protected $fillable = [
        'order_number',
        'email',
        'customer_name',
        'address',
        'subtotal',
        'discount',
        'tax',
        'total',
        'currency',
        'payment_method',
        'payment_gateway_id',
        'status',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the order items (line items).
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        $last = static::where('order_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('order_number');

        $seq = 1;
        if ($last && preg_match('/-(\d+)$/', $last, $m)) {
            $seq = (int) $m[1] + 1;
        }

        return $prefix . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Whether the order is paid/completed.
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Mark order as completed and set paid_at.
     */
    public function markAsPaid(?string $paymentGatewayId = null): void
    {
        $this->status = self::STATUS_COMPLETED;
        $this->paid_at = $this->paid_at ?? now();
        if ($paymentGatewayId !== null) {
            $this->payment_gateway_id = $paymentGatewayId;
        }
        $this->save();
    }

    /**
     * Create an order and order items from frontend cart data.
     * Cart items must have: type (product|package), id, name, price, qty, period (optional).
     *
     * @param  array<int, array{type?: string, id?: mixed, name?: string, price?: float|string, qty?: int, period?: string}>  $cart
     */
    public static function createFromCart(array $cart, float $total, string $paymentMethod, string $currency = 'USD'): self
    {
        $order = self::create([
            'order_number' => self::generateOrderNumber(),
            'subtotal' => $total,
            'discount' => 0,
            'tax' => 0,
            'total' => $total,
            'currency' => $currency,
            'payment_method' => $paymentMethod,
            'status' => self::STATUS_PENDING,
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
}
