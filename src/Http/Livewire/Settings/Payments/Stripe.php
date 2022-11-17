<?php

namespace Shopfolio\Http\Livewire\Settings\Payments;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Shopfolio\Models\Shop\PaymentMethod;
use Shopfolio\Models\System\Currency;
use WireUi\Traits\Actions;

class Stripe extends Component
{
    use Actions;

    public string $stripe_key = '';

    public string $stripe_secret = '';

    public bool $enabled = false;

    public string $message = '...';

    public function mount()
    {
        $this->enabled = ($stripe = PaymentMethod::where('slug', 'stripe')->first())
            ? $stripe->is_enabled
            : false;
        $this->stripe_key = env('STRIPE_KEY', '');
        $this->stripe_secret = env('STRIPE_SECRET', '');
    }

    public function enabledStripe()
    {
        PaymentMethod::create([
            'title' => 'Stripe',
            'slug' => 'stripe',
            'link_url' => 'https://github.com/stripe/stripe-php',
            'is_enabled' => true,
            'description' => 'The Stripe PHP library provides convenient access to the Stripe API from applications written in the PHP language.',
        ]);

        $this->enabled = true;

        $this->notification()->success(
            __('shopfolio::layout.status.success'),
            __('shopfolio::pages/settings.notifications.stripe_enable')
        );
    }

    public function store()
    {
        Artisan::call('config:clear');

        setEnvironmentValue([
            'stripe_key' => $this->stripe_key,
            'stripe_secret' => $this->stripe_secret,
        ]);

        $this->notification()->success(
            __('shopfolio::layout.status.updated'),
            __('shopfolio::pages/settings.notifications.stripe')
        );
    }

    public function render()
    {
        return view('shopfolio::livewire.settings.payments.stripe', [
            'currencies' => Cache::rememberForever('currencies', fn () => Currency::all()),
        ]);
    }
}
