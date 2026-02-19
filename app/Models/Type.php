<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    //
    protected $fillable = [
        'name',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the packages for the type.
     */
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
