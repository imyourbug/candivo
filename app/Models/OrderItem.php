<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    protected $table = 'order_items';
    public const ENTITY_PRODUCT = 'product';

    public const ENTITY_PACKAGE = 'package';

    protected $fillable = [
        'order_id',
        'entity_type',
        'entity_id',
        'name',
        'duration_months',
        'period_label',
        'quantity',
        'unit_price',
        'total_price',
        'currency',
        'metadata',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Resolve the sellable entity (Product or Package) for this line item.
     * Uses morph map: 'product' => Product::class, 'package' => Package::class.
     */
    public function entity(): MorphTo
    {
        return $this->morphTo('entity');
    }

    /**
     * Create an order item from a product and optional pricing/duration.
     */
    public static function fromProduct(Product $product, float $unitPrice, int $quantity = 1, ?int $durationMonths = null, ?string $periodLabel = null): array
    {
        $total = round($unitPrice * $quantity, 2);
        $periodLabel = $periodLabel ?? ($durationMonths ? "{$durationMonths} months" : null);

        return [
            'entity_type' => self::ENTITY_PRODUCT,
            'entity_id' => $product->id,
            'name' => $product->name,
            'duration_months' => $durationMonths,
            'period_label' => $periodLabel,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $total,
            'currency' => 'USD',
            'metadata' => [
                'slug' => $product->slug,
            ],
        ];
    }

    /**
     * Create an order item from a package and optional pricing/duration.
     */
    public static function fromPackage(Package $package, float $unitPrice, int $quantity = 1, ?int $durationMonths = null, ?string $periodLabel = null): array
    {
        $total = round($unitPrice * $quantity, 2);
        $periodLabel = $periodLabel ?? ($durationMonths ? "{$durationMonths} months" : null);

        return [
            'entity_type' => self::ENTITY_PACKAGE,
            'entity_id' => $package->id,
            'name' => $package->name,
            'duration_months' => $durationMonths,
            'period_label' => $periodLabel,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $total,
            'currency' => 'USD',
            'metadata' => [
                'slug' => $package->slug,
            ],
        ];
    }
}
