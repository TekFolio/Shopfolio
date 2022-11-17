<?php

namespace Shopfolio\Repositories;

use Shopfolio\Models\Shop\Inventory\Inventory;

class InventoryRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return Inventory::class;
    }
}
