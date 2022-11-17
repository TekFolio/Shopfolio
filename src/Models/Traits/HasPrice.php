<?php

namespace Shopfolio\Models\Traits;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

trait HasPrice
{
    public function formattedPrice(int|string $price): string
    {
        $money = new Money($price, new Currency(shopfolio_currency()));
        $currencies = new ISOCurrencies();

        $numberFormatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}
