<?php

namespace Shopfolio\Http\Livewire\Forms\Uploads;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Multiple extends Component
{
    use WithFileUploads;

    public $files = [];

    public $images = [];

    public string $inputId;

    protected $listeners = [
        'fileDeleted' => 'render',
    ];

    protected $rules = [
        'files.*' => 'nullable|max:5120',
    ];

    public function mount($images = [])
    {
        $this->images = $images;
        $this->inputId = 'files-upload-' . uniqid();
    }

    public function updatedFiles($files)
    {
        $filesUrl = collect();

        foreach ($files as $file) {
            $filesUrl->push($file->getRealPath());
        }

        $this->emitUp('shopfolio:filesUpdated', $filesUrl);
    }

    public function removeMedia(int $id)
    {
        Media::find($id)->delete();

        $this->emitSelf('fileDeleted');

        $this->notify([
            'title' => __('Removed'),
            'message' => __('Media removed from the storage.'),
        ]);
    }

    public function render(): View
    {
        return view('shopfolio::livewire.forms.uploads.multiple');
    }
}
