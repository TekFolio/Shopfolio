<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Shopfolio\Models\Shop\Order\Order;
use Shopfolio\Models\System\Currency as CurrencyModel;
use Shopfolio\Models\System\Setting;
use Shopfolio;

if (! \function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     */
    function app_name(): string
    {
        return config('app.name');
    }
}

if (! \function_exists('generate_number')) {
    /**
     * Generate Order Number.
     */
    function generate_number(): string
    {
        $lastOrder = Order::query()->orderBy('id', 'desc')->limit(1)->first();

        $generator = [
            'start_sequence_from' => 1,
            'prefix' => '#',
            'pad_length' => 1,
            'pad_string' => '0',
        ];

        $last = $lastOrder ? $lastOrder->id : 0;
        $next = $generator['start_sequence_from'] + $last;

        return sprintf(
            '%s%s',
            $generator['prefix'],
            str_pad($next, $generator['pad_length'], $generator['pad_string'], \STR_PAD_LEFT)
        );
    }
}

if (! \function_exists('setEnvironmentValue')) {
    /**
     * Function to set or update .env variable.
     */
    function setEnvironmentValue(array $values): bool
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (\count($values) > 0) {
            $str .= "\n"; // In case the searched variable is in the last line without \n
            foreach ($values as $envKey => $envValue) {
                if ($envValue === true) {
                    $value = 'true';
                } elseif ($envValue === false) {
                    $value = 'false';
                } else {
                    $value = $envValue;
                }

                $envKey = mb_strtoupper($envKey);
                $keyPosition = mb_strpos($str, "{$envKey}=");
                $endOfLinePosition = mb_strpos($str, "\n", $keyPosition);
                $oldLine = mb_substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                $space = mb_strpos($value, ' ');
                $envValue = $space === false ? $value : '"' . $value . '"';

                // If key does not exist, add it
                if (! $keyPosition || ! $endOfLinePosition || ! $oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
                env($envKey, $envValue);
            }
        }

        $str = mb_substr($str, 0, -1);

        if (! file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }
}

if (! \function_exists('shopfolio_version')) {
    /**
     * Function to return Shopfolio current version.
     */
    function shopfolio_version(): string
    {
        return Shopfolio::version();
    }
}

if (! \function_exists('shopfolio_table')) {
    /**
     * Return Shopfolio current table name.
     */
    function shopfolio_table(string $table): string
    {
        if (config('shopfolio.system.table_prefix') !== '') {
            return config('shopfolio.system.table_prefix') . $table;
        }

        return $table;
    }
}

if (! \function_exists('shopfolio_currency')) {
    /**
     * Return Shopfolio currency used.
     */
    function shopfolio_currency(): string
    {
        $settingCurrency = shopfolio_setting('shop_currency_id');

        if ($settingCurrency) {
            $currency = Cache::remember('shopfolio-currency', now()->addHour(), fn () => CurrencyModel::query()->find($settingCurrency));

            return $currency ? $currency->code : 'USD';
        }

        return 'USD';
    }
}

if (! \function_exists('shopfolio_money_format')) {
    /**
     * Return money format.
     */
    function shopfolio_money_format($amount, ?string $currency = null): string
    {
        $money = new Money($amount, new Currency($currency ?? shopfolio_currency()));
        $currencies = new ISOCurrencies();

        $numberFormatter = new \NumberFormatter(app()->getLocale(), \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}

if (! \function_exists('shopfolio_prefix')) {
    /**
     * Return Shopfolio prefix used.
     */
    function shopfolio_prefix(): string
    {
        return Shopfolio::prefix();
    }
}

if (! \function_exists('shopfolio_asset')) {
    /**
     * Return the full path of an image.
     */
    function shopfolio_asset(string $file, string $disk = 'uploads'): string
    {
        return Storage::disk(config('shopfolio.system.storage.disks.' . $disk))->url($file);
    }
}

if (! \function_exists('shopfolio_setting')) {
    /**
     * Return shopfolio setting from the setting table.
     */
    function shopfolio_setting(string $key): ?string
    {
        $setting = Cache::remember("shopfolio-setting-{$key}", 60 * 60 * 24, fn () => Setting::query()->where('key', $key)->first());

        return $setting?->value;
    }
}

if (! function_exists('active')) {
    /**
     * Sets the menu item class for an active route.
     */
    function active($routes, string $activeClass = 'active', string $defaultClass = '', bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], (array) $routes) && $condition ? $activeClass : $defaultClass;
    }
}

if (! function_exists('is_active')) {
    /**
     * Determines if the given routes are active.
     */
    function is_active($routes): bool
    {
        return (bool) call_user_func_array([app('router'), 'is'], (array) $routes);
    }
}
