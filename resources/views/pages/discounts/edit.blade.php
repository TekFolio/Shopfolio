<x-shopfolio::layouts.app :title="__('shopfolio::pages/discounts.actions.update', ['code' => $discount->code])">

    <livewire:shopfolio-discounts.edit :discount="$discount" />

</x-shopfolio::layouts.app>
