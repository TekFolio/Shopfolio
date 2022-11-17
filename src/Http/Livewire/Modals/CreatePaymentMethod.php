<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Models\Shop\PaymentMethod;
use WireUi\Traits\Actions;

class CreatePaymentMethod extends ModalComponent
{
    use Actions;
    use WithFileUploads;

    public string $title = '';

    public ?string $linkUrl = null;

    public ?string $description = null;

    public ?string $instructions = null;

    public $logo;

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|unique:' . shopfolio_table('payment_methods'),
            'logo' => 'nullable|image|max:2048',
        ]);

        $paymentMethod = PaymentMethod::query()->create([
            'title' => $this->title,
            'slug' => $this->title,
            'link_url' => $this->linkUrl,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'is_enabled' => true,
        ]);

        if ($this->logo) {
            $paymentMethod->update([
                'logo' => $this->logo->store('/', config('shopfolio.system.storage.disks.uploads')),
            ]);
        }

        $this->notification()->success(__('Saved'), __('Your payment method have been correctly added!'));

        $this->emit('onPaymentMethodAdded');

        $this->closeModal();
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.create-payment-method');
    }
}
