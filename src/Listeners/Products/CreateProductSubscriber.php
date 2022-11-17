<?php

namespace Shopfolio\Listeners\Products;

use function count;
use Shopfolio\Events\Products\ProductCreated;

class CreateProductSubscriber
{
    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event)
    {
        if (count($event->quantity) > 0) {
            foreach ($event->quantity as $inventory => $quantity) {
                $event->product->mutateStock(
                    $inventory,
                    $event->quantity,
                    [
                        'event' => __('Initial inventory'),
                        'old_quantity' => $quantity,
                    ]
                );
            }
        }
    }
}
