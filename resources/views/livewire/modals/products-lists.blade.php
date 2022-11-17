<x-shopfolio::modal
    headerClasses="p-4 sm:px-6 sm:py-4 border-b border-secondary-100 dark:border-secondary-700"
    contentClasses="relative p-4 sm:px-6 sm:px-5"
    footerClasses="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
>
    <x-slot name="title">
        {{ __('shopfolio::pages/collections.modal.title') }}
    </x-slot>

    <x-slot name="content">
        <div class="py-2">
            <x-shopfolio::forms.search label="shopfolio::pages/collections.modal.search" placeholder="shopfolio::pages/collections.modal.search_placeholder" />
        </div>
        <div class="my-2 -mx-2 divide-y divide-secondary-200 h-80 overflow-auto dark:divide-secondary-700">
            @foreach($this->products as $product)
                <x-shopfolio::forms.label-product :product="$product" wire:key="{{ $product->id }}" />
            @endforeach
        </div>
    </x-slot>

    <x-slot name="buttons">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <x-shopfolio::buttons.primary wire:click="addSelectedProducts" wire.loading.attr="disabled" type="button">
                <x-shopfolio::loader wire:loading wire:target="addSelectedProducts" class="text-white" />
                {{ __('shopfolio::pages/collections.modal.action') }}
            </x-shopfolio::buttons.primary>
            </span>
        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <x-shopfolio::buttons.default wire:click="$emit('closeModal')" type="button">
                {{ __('shopfolio::layout.forms.actions.cancel') }}
            </x-shopfolio::buttons.default>
        </span>
    </x-slot>

</x-shopfolio::modal>
