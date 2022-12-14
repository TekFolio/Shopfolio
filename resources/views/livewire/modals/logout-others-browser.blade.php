<x-shopfolio::modal
    contentClasses="relative p-4 sm:px-6 sm:px-5"
    footerClasses="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
>

    <x-slot name="content">
        <div class="sm:flex sm:items-start px-4 sm:px-6 pt-4">
            <div class="text-left">
                <h3 class="text-lg leading-6 font-medium text-secondary-900 dark:text-white">
                    {{ __('Logout Other Browser Sessions') }}
                </h3>
                <p class="mt-1 text-sm leading-5 text-secondary-500 dark:text-secondary-400">
                    {{ __('Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.') }}
                </p>
            </div>
        </div>
        <div class="p-4 sm:px-6">
            <div>
                <div class="relative">
                    <x-shopfolio::forms.input wire:model.lazy="password" aria-label="{{ __('Password') }}" type="password" placeholder="{{ __('Enter your password') }}" />
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-shopfolio::buttons.danger wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled" type="button">
                <x-shopfolio::loader wire:loading wire:target="logoutOtherBrowserSessions" class="text-white" />
                {{ __('Logout Other Browser Sessions') }}
            </x-shopfolio::buttons.danger>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-shopfolio::buttons.default wire:click="$emit('closeModal')" wire:loading.attr="disabled" type="button">
                {{ __('Nevermind') }}
            </x-shopfolio::buttons.default>
        </span>
    </x-slot>

</x-shopfolio::modal>
