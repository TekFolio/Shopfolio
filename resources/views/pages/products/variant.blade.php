<x-shopfolio::layouts.app :title=" __('Variants ~ :name', ['name' => $variant->name])">

    <livewire:shopfolio-products.variant :product="$product" :variant="$variant" :currency="shopfolio_currency()" />

</x-shopfolio::layouts.app>
