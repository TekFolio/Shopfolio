<?php

namespace Shopfolio\Http\Livewire\Collections;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Shopfolio\Http\Livewire\AbstractBaseComponent;
use Shopfolio\Repositories\Ecommerce\CollectionRepository;
use Shopfolio\Traits\WithConditions;
use Shopfolio\Traits\WithSeoAttributes;

class Edit extends AbstractBaseComponent
{
    use WithConditions;
    use WithSeoAttributes;

    public Model $collection;

    public Collection $products;

    public int $collectionId;

    public string $name = '';

    public ?string $description = null;

    public string $type = 'auto';

    public ?string $publishedAt = null;

    public ?string $publishedAtFormatted = null;

    public string $condition_match = 'all';

    public ?string $fileUrl = null;

    public $seoAttributes = [
        'name' => 'name',
        'description' => 'description',
    ];

    protected $listeners = [
        'shopfolio:fileUpdated' => 'onFileUpdate',
        'trix:valueUpdated' => 'onTrixValueUpdate',
    ];

    public function mount($collection)
    {
        $this->collection = $collection;
        $this->products = $collection->products;
        $this->collectionId = $collection->id;
        $this->name = $collection->name;
        $this->description = $collection->description;
        $this->type = $collection->type;
        $this->condition_match = $collection->match_conditions;
        $this->publishedAt = $collection->published_at;
        $this->publishedAtFormatted = Carbon::createFromFormat('Y-m-d', $collection->published_at->toDateString())->toRfc7231String();
        $this->updateSeo = true;
        $this->seoTitle = $collection->seo_title ?? $collection->name;
        $this->seoDescription = $collection->seo_description;
    }

    public function onTrixValueUpdate($value)
    {
        $this->description = $value;
    }

    public function onFileUpdate($file)
    {
        $this->fileUrl = $file;
    }

    public function store()
    {
        $this->validate($this->rules());

        (new CollectionRepository())->getById($this->collection->id)->update([
            'name' => $this->name,
            'slug' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'match_conditions' => $this->condition_match,
            'seo_title' => $this->seoTitle,
            'seo_description' => str_limit($this->seoDescription, 157),
            'published_at' => $this->publishedAt,
        ]);

        if ($this->fileUrl) {
            $this->collection->addMedia($this->fileUrl)->toMediaCollection(config('shopfolio.system.storage.disks.uploads'));
        }

        session()->flash('success', __('Collection successfully updated!'));

        $this->redirectRoute('shopfolio.collections.index');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'max:150',
                Rule::unique(shopfolio_table('collections'), 'name')->ignore($this->collectionId),
            ],
            'type' => 'sometimes|required',
        ];
    }

    public function isUpdate(): bool
    {
        return true;
    }

    public function updatedPublishedAt($value)
    {
        $this->publishedAtFormatted = Carbon::createFromFormat('Y-m-d H:i', $value)->toRfc7231String();
    }

    public function render(): View
    {
        return view('shopfolio::livewire.collections.edit');
    }
}
