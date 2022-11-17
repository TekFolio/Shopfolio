<?php

namespace Shopfolio\Repositories\Ecommerce;

use Shopfolio\Repositories\BaseRepository;

class BrandRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return config('shopfolio.system.models.brand');
    }
}
