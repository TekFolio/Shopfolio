<x-shopfolio::modal
    headerClasses="p-4 sm:px-6 sm:py-4 border-b border-secondary-100 dark:border-secondary-700"
    contentClasses="relative p-4 sm:px-6 sm:px-5"
    footerClasses="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
>

    <x-slot name="title">
        {{ __('Add new payment method') }}
    </x-slot>

    <x-slot name="content">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 h-96 overflow-y-scroll hide-scroll">
            <div class="sm:col-span-2">
                <div>
                    <x-shopfolio::label value="{{ __('Provider Logo') }}" />
                    <div class="mt-2">
                        <x-shopfolio::forms.avatar-upload id="logo" wire:model.lazy='logo'>
                            <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-secondary-100 dark:bg-secondary-700">
                                @if($logo)
                                    <img class="h-full w-full bg-center" src="{{ $logo->temporaryUrl() }}" alt="">
                                @else
                                    <span class="h-12 w-12 flex items-center justify-center">
                                        <x-heroicon-o-photograph class="w-8 h-8 text-secondary-400 dark:text-secondary-500" />
                                    </span>
                                @endif
                            </span>
                        </x-shopfolio::forms.avatar-upload>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-2">
                <x-shopfolio::forms.group label="Custom payment method name" for="title" :error="$errors->first('title')" isRequired>
                    <x-shopfolio::forms.input wire:model.defer="title" id="title" type="text" />
                </x-shopfolio::forms.group>
            </div>
            <div class="sm:col-span-2">
                <x-shopfolio::forms.group label="Payment Website Documentation" for="link_url">
                    <x-shopfolio::forms.input wire:model.defer="linkUrl" type="url" id="link_url" placeholder="https://doc.myprovider.com" />
                </x-shopfolio::forms.group>
            </div>
            <div class="sm:col-span-2">
                <x-shopfolio::forms.group label="Additional details" for="description" helpText="Displays to customers when they’re choosing a payment method.">
                    <x-shopfolio::forms.textarea wire:model.defer="description" id="description" />
                </x-shopfolio::forms.group>
            </div>
            <div class="sm:col-span-2">
                <x-shopfolio::forms.group label="Payment instructions" for="instructions" helpText="Displays to customers after they place an order with this payment method.">
                    <x-shopfolio::forms.textarea wire:model.defer="instructions" id="instructions" />
                </x-shopfolio::forms.group>
            </div>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-shopfolio::buttons.primary wire:click="save" type="button">
                <x-shopfolio::loader wire:loading wire:target="save" class="text-white" />
                {{ __('Save') }}
            </x-shopfolio::buttons.primary>
        </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-shopfolio::buttons.default wire:click="$emit('closeModal')" type="button">
                {{ __('Cancel') }}
            </x-shopfolio::buttons.default>
        </span>
    </x-slot>

</x-shopfolio::modal>
