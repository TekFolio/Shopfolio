@if(! empty(config('shopfolio.system.resources.stylesheets')))
    <!-- Additional CSS -->
    @foreach(config('shopfolio.system.resources.stylesheets') as $css)
        @if (starts_with($css, ['http://', 'https://']))
            <link rel="stylesheet" type="text/css" href="{!! $css !!}">
        @else
            <link rel="stylesheet" type="text/css" href="{{ asset($css) }}">
        @endif
    @endforeach
@endif
