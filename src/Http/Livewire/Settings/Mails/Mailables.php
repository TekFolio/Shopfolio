<?php

namespace Shopfolio\Http\Livewire\Settings\Mails;

use Livewire\Component;
use Shopfolio\Services\Mailable;

class Mailables extends Component
{
    public bool $isLocal = false;

    protected $listeners = ['onMailableAction' => '$refresh'];

    public function mount()
    {
        if (in_array(app()->environment(), config('shopfolio.mails.allowed_environments'))) {
            $this->isLocal = true;
        }
    }

    public function render()
    {
        return view('shopfolio::livewire.settings.mails.mailables', [
            'mailables' => (null !== $mailables = Mailable::getMailables())
                ? $mailables->sortBy('name')
                : collect([]),
        ]);
    }
}
