<?php

namespace Shopfolio\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Shopfolio\Models\Traits\HasSlug;

class Carrier extends Model
{
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return shopfolio_table('carriers');
    }
}
