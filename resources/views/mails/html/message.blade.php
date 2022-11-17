@component('shopfolio::mails.html.layout')
    {{-- Header --}}
    @slot('header')
        @component('shopfolio::mails.html.header', ['url' => config('app.url'), 'description' => __('Online Shopping tool')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('shopfolio::mails.html.subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('shopfolio::mails.html.footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
