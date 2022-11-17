<x-shopfolio::layouts.app :title="__('shopfolio::pages/auth.account.meta_title')">

    <x-shopfolio::heading>
        <x-slot name="title">
            {{ __('shopfolio::pages/auth.account.title') }}
        </x-slot>
    </x-shopfolio::heading>

    <livewire:shopfolio-account.profile />

    <div class="hidden sm:block">
        <div class="py-5">
            <div class="border-t border-secondary-200 dark:border-secondary-700"></div>
        </div>
    </div>

    <livewire:shopfolio-account.password />

    @if (config('shopfolio.auth.2fa_enabled'))
        <div class="hidden sm:block">
            <div class="py-5">
                <div class="border-t border-secondary-200 dark:border-secondary-700"></div>
            </div>
        </div>

        <livewire:shopfolio-account.two-factor />
    @endif

    <div class="hidden sm:block">
        <div class="py-5">
            <div class="border-t border-secondary-200 dark:border-secondary-700"></div>
        </div>
    </div>

    <livewire:shopfolio-account.devices />

</x-shopfolio::layouts.app>
