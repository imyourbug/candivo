<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'status',
        'value_status',
        'is_basic',
        'is_professional',
        'is_premium',
        'cat_set',
        'stand_set',
        'avatar',
        'video',
        'images',

    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the packages that this product belongs to.
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_products');
    }

    /**
     * Get the pricing records for this product.
     */
    public function pricing(): HasMany
    {
        return $this->hasMany(Pricing::class, 'entity_id')
            ->where('entity_type', 'product');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
