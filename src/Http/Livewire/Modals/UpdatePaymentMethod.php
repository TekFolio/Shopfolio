<?php

namespace Shopfolio\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Shopfolio\Models\Shop\PaymentMethod;
use WireUi\Traits\Actions;

class UpdatePaymentMethod extends ModalComponent
{
    use Actions;
    use WithFileUploads;

    public PaymentMethod $paymentMethod;

    public string $title = '';

    public ?string $linkUrl = null;

    public ?string $description = null;

    public ?string $instructions = null;

    public ?string $logoUrl;

    public $logo;

    public function mount(int $id)
    {
        $this->paymentMethod = $paymentMethod = PaymentMethod::find($id);
        $this->title = $paymentMethod->title;
        $this->description = $paymentMethod->description;
        $this->linkUrl = $paymentMethod->link_url;
        $this->instructions = $paymentMethod->instructions;
        $this->logoUrl = $paymentMethod->logo_url;
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function save()
    {
        $this->validate([
            'title' => [
                'required',
                Rule::unique(shopfolio_table('payment_methods'), 'title')->ignore($this->paymentMethod->id),
            ],
            'logo' => 'nullable|image|max:2048',
        ]);

        $this->paymentMethod->update([
            'title' => $this->title,
            'slug' => $this->title,
            'link_url' => $this->linkUrl,
            'description' => $this->description,
            'instructions' => $this->instructions,
        ]);

        if ($this->logo) {
            $this->paymentMethod->update([
                'logo' => $this->logo->store('/', config('shopfolio.system.storage.disks.uploads')),
            ]);
        }

        $this->notification()->success(__('Updated'), __('Your payment method have been correctly updated.'));

        $this->emit('onPaymentMethodAdded');

        $this->closeModal();
    }

    public function render(): View
    {
        return view('shopfolio::livewire.modals.update-payment-method');
    }
}
