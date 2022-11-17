<?php

namespace Shopfolio\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Shopfolio\Models\Shop\DiscountDetail;

trait CanHaveDiscount
{
    public function discounts(): MorphToMany
    {
        return $this->morphedByMany(DiscountDetail::class, 'discountable')->orderBy('created_at', 'desc');
    }
}
