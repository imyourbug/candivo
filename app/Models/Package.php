<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'category_id',
        'type_id',
        'name',
        'slug',
        'description',
        'avatar',
        'video',
        'images',
    ];

    /**
     * Get the products for the package.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'package_products');
    }

    /**
     * Get the pricing records for this package.
     */
    public function pricing(): HasMany
    {
        return $this->hasMany(Pricing::class, 'entity_id')
            ->where('entity_type', 'package');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function getImagesAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
