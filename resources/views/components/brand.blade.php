@if (filled($brand = config('shopfolio.system.brand')))
    <img {{ $attributes }} src="{{ asset($brand) }}" alt="{{ config('app.name') }}" />
@else
    <img {{ $attributes }} src="{{ asset('shopfolio/images/shopfolio-icon.svg') }}" alt="Laravel Shopfolio" />
@endif
