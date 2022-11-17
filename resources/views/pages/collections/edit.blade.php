<x-shopfolio::layouts.app :title="__('shopfolio::messages.actions_label.edit', ['name' => $collection->name])">

    <livewire:shopfolio-collections.edit :collection="$collection" />

</x-shopfolio::layouts.app>
