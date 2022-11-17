<?php

namespace Shopfolio\Helpers;

use Shopfolio\Models\Traits\HasPrice;

class Price
{
    use HasPrice;

    public int $cent;

    public int $amount;

    public string $formatted;

    public string $currency;

    public function __construct(int $cent)
    {
        $this->cent = $cent;
        $this->amount = $cent / 100;
        $this->currency = shopfolio_currency();
        $this->formatted = $this->formattedPrice($this->amount);
    }

    public static function from(int $cent): self
    {
        return new self($cent);
    }
}
