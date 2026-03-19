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

}
