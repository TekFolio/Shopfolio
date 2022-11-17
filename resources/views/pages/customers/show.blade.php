<x-shopfolio::layouts.app :title="__('shopfolio::messages.actions_label.show', ['name' => $customer->name])">

    <livewire:shopfolio-customers.show :customer="$customer" />

</x-shopfolio::layouts.app>
