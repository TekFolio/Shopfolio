<?php

namespace Shopfolio\Http\Livewire\Categories;

use Illuminate\Contracts\View\View;
use Shopfolio\Http\Livewire\AbstractBaseComponent;
use Shopfolio\Repositories\Ecommerce\CategoryRepository;
use Shopfolio\Traits\WithChoicesCategories;
use Shopfolio\Traits\WithSeoAttributes;

class Create extends AbstractBaseComponent
{
    use WithChoicesCategories;
    use WithSeoAttributes;

    public string $name = '';

    public ?int $parent_id = null;

    public ?string $description = null;

    public bool $is_enabled = true;

    public ?string $fileUrl = null;

    public $parent;

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

    public function store(): void
    {
        $this->validate($this->rules());

        $category = (new CategoryRepository())->create([
            'name' => $this->name,
            'slug' => $this->parent ? $this->parent->slug . '-' . $this->name : $this->name,
            'parent_id' => $this->parent_id,
            'description' => $this->description,
            'is_enabled' => $this->is_enabled,
            'seo_title' => $this->seoTitle,
            'seo_description' => $this->seoDescription,
        ]);

        if ($this->fileUrl) {
            $category->addMedia($this->fileUrl)->toMediaCollection(config('shopfolio.system.storage.disks.uploads'));
        }

        session()->flash('success', __('Category successfully added!'));

        $this->redirectRoute('shopfolio.categories.index');
    }

    public function rules(): array
    {
        return ['name' => 'required|max:150'];
    }

    public function render(): View
    {
        return view('shopfolio::livewire.categories.create', [
            'categories' => (new CategoryRepository())
                ->makeModel()
                ->scopes('enabled')
                ->tree()
                ->orderBy('name')
                ->get()
                ->toTree(),
        ]);
    }
}
