<?php

namespace Shopfolio\Http\Livewire\Collections;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Shopfolio\Models\Shop\Product\CollectionRule;
use Shopfolio\Repositories\Ecommerce\CollectionRepository;
use Shopfolio\Traits\WithConditions;
use Shopfolio\Traits\WithSeoAttributes;

class Create extends Component
{
    use WithConditions;
    use WithSeoAttributes;

    public string $name = '';

    public ?string $description = null;

    public string $type = 'auto';

    public ?string $publishedAt = null;

    public ?string $publishedAtFormatted = null;

    public ?string $fileUrl = null;

    public string $condition_match = 'all';

    public $seoAttributes = [
        'name' => 'name',
        'description' => 'description',
    ];

    protected $listeners = [
        'trix:valueUpdated' => 'onTrixValueUpdate',
        'shopfolio:fileUpdated' => 'onFileUpdate',
    ];

    public function onTrixValueUpdate($value)
    {
        $this->description = $value;
    }

    public function onFileUpdate($file)
    {
        $this->fileUrl = $file;
    }

    public function updatedPublishedAt($value)
    {
        if ($value) {
            $this->publishedAtFormatted = Carbon::createFromFormat('Y-m-d H:i', $value)->toRfc7231String();
        }
    }

    public function store()
    {
        $this->validate($this->rules());

        $collection = (new CollectionRepository())->create([
            'name' => $this->name,
            'slug' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'match_conditions' => $this->condition_match,
            'seo_title' => $this->seoTitle,
            'seo_description' => $this->seoDescription,
            'published_at' => $this->publishedAt ?? now(),
        ]);

        if ($this->fileUrl) {
            $collection->addMedia($this->fileUrl)->toMediaCollection(config('shopfolio.system.storage.disks.uploads'));
        }

        if ($this->type === 'auto' && count($this->conditions) > 0 && $this->rule) {
            foreach ($this->rule as $key => $value) {
                CollectionRule::query()->create([
                    'collection_id' => $collection->id,
                    'rule' => $this->rule[$key],
                    'operator' => $this->operator[$key],
                    'value' => $this->value[$key],
                ]);
            }

            $this->conditions = [];
            $this->resetConditionsFields();
        }

        session()->flash('success', __('Collection successfully added!'));

        $this->redirectRoute('shopfolio.collections.edit', $collection);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:150|unique:' . shopfolio_table('collections'),
            'type' => 'required',
        ];
    }

    public function render(): View
    {
        return view('shopfolio::livewire.collections.create');
    }
}
