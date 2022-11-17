<?php

namespace Shopfolio\Http\Livewire\Settings\Legal;

use Livewire\Component;
use Shopfolio\Traits\WithLegalActions;
use WireUi\Traits\Actions;

class Privacy extends Component
{
    use Actions;
    use WithLegalActions;

    public string $title = 'Privacy policy';

    protected $listeners = [
        'trix:valueUpdated' => 'onTrixValueUpdate',
    ];

    public function onTrixValueUpdate($value)
    {
        $this->content = $value;
    }

    public function store()
    {
        $this->storeValues($this->title, $this->content, $this->isEnabled);

        $this->notification()->success(__('Updated'), __('Your privacy policy has been successfully updated!'));
    }

    public function render()
    {
        return view('shopfolio::livewire.settings.legal.privacy');
    }
}
