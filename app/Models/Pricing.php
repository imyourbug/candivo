<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = [
        'entity_id',
        'entity_type',
        'duration_months',
        'price',
        'currency',
    ];

    /**
     * Get the polymorphic entity (Product or Package).
     */
    public function entity()
    {
        if ($this->entity_type === 'product') {
            return $this->belongsTo(Product::class, 'entity_id')->first();
        } elseif ($this->entity_type === 'package') {
            return $this->belongsTo(Package::class, 'entity_id')->first();
        }
        return null;
    }

    /**
     * Scope to get pricing for products only.
     */
    public function scopeForProducts($query)
    {
        return $query->where('entity_type', 'product');
    }

    /**
     * Scope to get pricing for packages only.
     */
    public function scopeForPackages($query)
    {
        return $query->where('entity_type', 'package');
    }
}
