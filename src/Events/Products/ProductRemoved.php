<?php

namespace Shopfolio\Events\Products;

use Illuminate\Queue\SerializesModels;

class ProductRemoved
{
    use SerializesModels;

    /**
     * Product Model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $product;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $product
     */
    public function __construct($product)
    {
        $this->product = $product;
    }
}
