<x-shopfolio::layouts.app :title="__('shopfolio::messages.actions_label.edit', ['name' => $product->name])">

    <livewire:shopfolio-products.edit :product="$product" />

</x-shopfolio::layouts.app>
