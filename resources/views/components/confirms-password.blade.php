@props([
    'title' => __('shopfolio::layout.forms.label.confirm_password'),
    'content' => __('shopfolio::components.modal.content'),
    'button' => __('shopfolio::layout.forms.label.confirm')
])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
    <x-shopfolio::dialog-modal wire:model="confirmingPassword" maxWidth="lg">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="content">
            <p class="text-sm leading-5 text-secondary-500 dark:text-secondary-400">{{ $content }}</p>

            <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
                <x-shopfolio::forms.input
                    x-ref="confirmable_password"
                    wire:model.defer="confirmablePassword"
                    wire:keydown.enter="confirmPassword"
                    id="confirmable_password"
                    type="password"
                    placeholder="{{ __('shopfolio::layout.forms.placeholder.password') }}"
                    aria-label="{{ __('shopfolio::layout.forms.label.password') }}"
                />

                @error('confirmable_password')
                    <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <x-shopfolio::buttons.primary wire:click="confirmPassword" wire:loading.attr="disabled" type="button">
                    <x-shopfolio::loader wire:loading wire:target="confirmPassword" class="text-white" />
                    {{ $button }}
                </x-shopfolio::buttons.primary>
            </span>

            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <x-shopfolio::buttons.default wire:click="stopConfirmingPassword" wire:loading.attr="disabled" type="button">
                    {{ __('shopfolio::layout.forms.actions.nevermind') }}
                </x-shopfolio::buttons.default>
            </span>
        </x-slot>
    </x-shopfolio::dialog-modal>
@endonce
