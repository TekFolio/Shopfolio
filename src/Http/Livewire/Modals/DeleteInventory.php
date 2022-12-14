<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Models\Shop\Inventory\Inventory;

class DeleteInventory extends ModalComponent
{
    public int $inventoryId;

    public string $name;

    public function mount(int $inventoryId, string $name)
    {
        $this->inventoryId = $inventoryId;
        $this->name = $name;
    }

    public function delete()
    {
        Inventory::query()->find($this->inventoryId)->delete();

        session()->flash('success', __('Inventory Successfully removed.'));

        $this->redirectRoute('shopfolio.settings.inventories.index');
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.delete-inventory');
    }
}
