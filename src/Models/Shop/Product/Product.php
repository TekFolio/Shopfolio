<?php

namespace Shopfolio\Models\Shop\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Shopfolio\Contracts\ReviewRateable;
use Shopfolio\Models\Shop\Channel;
use Shopfolio\Models\Traits\CanHaveDiscount;
use Shopfolio\Models\Traits\HasPrice;
use Shopfolio\Models\Traits\HasSlug;
use Shopfolio\Models\Traits\HasStock;
use Shopfolio\Models\Traits\ReviewRateable as ReviewRateableTrait;
use Shopfolio\Helpers\Price;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Product extends Model implements HasMedia, ReviewRateable
{
    use CanHaveDiscount;
    use HasFactory;
    use HasPrice;
    use HasRecursiveRelationships;
    use HasStock;
    use HasSlug;
    use InteractsWithMedia;
    use ReviewRateableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'security_stock',
        'featured',
        'is_visible',
        'brand_id',
        'parent_id',
        'old_price_amount',
        'price_amount',
        'cost_amount',
        'type',
        'published_at',
        'backorder',
        'requires_shipping',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
        'depth_value',
        'depth_unit',
        'volume_value',
        'seo_title',
        'seo_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'featured' => 'boolean',
        'is_visible' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return shopfolio_table('products');
    }

    /**
     * Get the formatted price value.
     */
    public function getFormattedPriceAttribute(): ?string
    {
        if ($this->parent_id) {
            return $this->price_amount
                ? $this->formattedPrice($this->price_amount)
                : ($this->parent->price_amount ? $this->formattedPrice($this->parent->price_amount) : null);
        }

        return $this->price_amount
                ? $this->formattedPrice($this->price_amount)
                : null;
    }

    public function getPriceAttribute(): ?Price
    {
        if (! $this->price_amount) {
            return null;
        }

        return Price::from($this->price_amount);
    }

    /**
     * Get the stock of all variations.
     */
    public function getVariationsStockAttribute(): int
    {
        $stock = 0;

        if ($this->variations->isNotEmpty()) {
            foreach ($this->variations as $variation) {
                $stock += $variation->stock;
            }
        }

        return $stock;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(config('shopfolio.system.storage.disks.uploads'))
            ->useFallbackUrl(url(shopfolio_prefix() . '/images/product_placeholder.jpg'));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb200x200')
            ->fit(Manipulations::FIT_CROP, 200, 200);
    }

    public function scopePublish(Builder $query): Builder
    {
        return $query->whereDate('published_at', '<=', now())
            ->where('is_visible', true);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(config('shopfolio.system.models.product'), 'parent_id');
    }

    public function channels(): MorphToMany
    {
        return $this->morphedByMany(Channel::class, 'productable', 'product_has_relations');
    }

    public function relatedProducts(): MorphToMany
    {
        return $this->morphedByMany(config('shopfolio.system.models.product'), 'productable', 'product_has_relations');
    }

    public function categories(): MorphToMany
    {
        return $this->morphedByMany(config('shopfolio.system.models.category'), 'productable', 'product_has_relations');
    }

    public function collections(): MorphToMany
    {
        return $this->morphedByMany(config('shopfolio.system.models.collection'), 'productable', 'product_has_relations');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(config('shopfolio.system.models.brand'), 'brand_id');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
