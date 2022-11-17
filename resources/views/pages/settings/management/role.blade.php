<x-shopfolio::layouts.setting :title="__('Roles') . ' ' . $role->display_name">

    <livewire:shopfolio-settings.management.role :role="$role" />

</x-shopfolio::layouts.setting>
