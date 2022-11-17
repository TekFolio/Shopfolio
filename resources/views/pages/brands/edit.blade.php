<x-shopfolio::layouts.app :title="__('shopfolio::messages.actions_label.edit', ['name' => $brand->name])">

    <livewire:shopfolio-brands.edit :brand="$brand" />

</x-shopfolio::layouts.app>
