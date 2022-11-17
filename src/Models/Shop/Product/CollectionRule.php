<?php

namespace Shopfolio\Models\Shop\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionRule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule',
        'operator',
        'value',
        'collection_id',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string
    {
        return shopfolio_table('collection_rules');
    }

    public function getFormattedRule(): string
    {
        return [
            'product_title' => __('shopfolio::pages/collections.rules.product_title'),
            'product_brand' => __('shopfolio::pages/collections.rules.product_brand'),
            'product_category' => __('shopfolio::pages/collections.rules.product_category'),
            'product_price' => __('shopfolio::pages/collections.rules.product_price'),
            'compare_at_price' => __('shopfolio::pages/collections.rules.compare_at_price'),
            'inventory_stock' => __('shopfolio::pages/collections.rules.inventory_stock'),
        ][$this->rule];
    }

    public function getFormattedOperator(): string
    {
        return [
            'equals_to' => __('shopfolio::pages/collections.operator.equals_to'),
            'not_equals_to' => __('shopfolio::pages/collections.operator.not_equals_to'),
            'less_than' => __('shopfolio::pages/collections.operator.less_than'),
            'greater_than' => __('shopfolio::pages/collections.operator.greater_than'),
            'starts_with' => __('shopfolio::pages/collections.operator.starts_with'),
            'ends_with' => __('shopfolio::pages/collections.operator.ends_with'),
            'contains' => __('shopfolio::pages/collections.operator.contains'),
            'not_contains' => __('shopfolio::pages/collections.operator.not_contains'),
        ][$this->operator];
    }

    public function getFormattedValue(): string
    {
        if ($this->rule === 'product_price') {
            return shopfolio_money_format(strtoupper($this->value));
        }

        return $this->value;
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(config('shopfolio.system.models.collection'), 'collection_id');
    }
}
