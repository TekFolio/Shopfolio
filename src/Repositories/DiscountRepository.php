<?php

namespace Shopfolio\Repositories;

use Shopfolio\Models\Shop\Discount;

class DiscountRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return Discount::class;
    }
}
