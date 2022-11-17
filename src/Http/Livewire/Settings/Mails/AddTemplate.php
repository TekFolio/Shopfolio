<?php

namespace Shopfolio\Http\Livewire\Settings\Mails;

use Livewire\Component;
use Shopfolio\Services\Mailable;

class AddTemplate extends Component
{
    public function render()
    {
        return view('shopfolio::livewire.settings.mails.templates.add-template', [
            'skeletons' => Mailable::getTemplateSkeletons(),
        ]);
    }
}
