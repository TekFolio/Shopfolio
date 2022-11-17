<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class DeleteMailable extends ModalComponent
{
    use Actions;

    public string $item;

    public function mount(string $item)
    {
        $this->item = $item;
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function delete()
    {
        $mailableFile = config('shopfolio.mails.mailables_dir') . $this->item . '.php';

        if (file_exists($mailableFile)) {
            unlink($mailableFile);

            $this->notification()->success(__('Removed'), __('You have removed the :class', ['class' => $this->item]));
        } else {
            session()->flash('error', __("This file don't exist."));
        }

        $this->emit('onMailableAction');

        $this->closeModal();
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.delete-mailable');
    }
}
