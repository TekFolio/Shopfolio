<x-shopfolio::layouts.app :title="__('shopfolio::messages.actions_label.edit', ['name' => $category->name])">

    <livewire:shopfolio-categories.edit :category="$category" />

</x-shopfolio::layouts.app>
