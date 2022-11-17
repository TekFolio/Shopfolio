<?php

namespace Shopfolio\Models\Shop;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Shopfolio\Models\Traits\HasSlug;

class Legal extends Model
{
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_enabled',
    ];

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
        return shopfolio_table('legals');
    }

    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }
}
