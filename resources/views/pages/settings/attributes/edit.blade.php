<x-shopfolio::layouts.setting :title="__('Update attribute :attribute', ['attribute' => $attribute->name])">

    <livewire:shopfolio-settings.attributes.edit :attribute="$attribute" />

</x-shopfolio::layouts.setting>
