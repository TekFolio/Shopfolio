<?php

namespace Shopfolio\Repositories\Ecommerce;

use Shopfolio\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return config('shopfolio.system.models.product');
    }
}
