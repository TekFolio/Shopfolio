<?php

namespace Shopfolio\Repositories;

use Shopfolio\Models\Shop\Inventory\InventoryHistory;

class InventoryHistoryRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     */
    public function model()
    {
        return InventoryHistory::class;
    }
}
