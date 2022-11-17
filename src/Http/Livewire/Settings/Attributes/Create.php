<?php

namespace Shopfolio\Http\Livewire\Settings\Attributes;

use Shopfolio\Http\Livewire\AbstractBaseComponent;
use Shopfolio\Models\Shop\Product\Attribute;

class Create extends AbstractBaseComponent
{
    public string $name = '';

    public string $slug = '';

    public string $type = 'text';

    public ?string $description = null;

    public bool $isEnabled = false;

    public bool $isSearchable = false;

    public bool $isFilterable = false;

    public function updatedName(string $value)
    {
        $this->slug = str_slug($value);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:75',
            'slug' => 'required|unique:' . shopfolio_table('attributes'),
            'type' => 'required',
        ];
    }

    public function store()
    {
        $this->validate($this->rules());

        $attribute = Attribute::query()->create([
            'name' => $this->name,
            'slug' => str_slug($this->slug, '-'),
            'type' => $this->type,
            'description' => $this->description,
            'is_enabled' => $this->isEnabled,
            'is_searchable' => $this->isSearchable,
            'is_filterable' => $this->isFilterable,
        ]);

        session()->flash('success', __('Attribute successfully added'));

        $this->redirectRoute('shopfolio.settings.attributes.edit', $attribute);
    }

    public function render()
    {
        return view('shopfolio::livewire.settings.attributes.create', [
            'fields' => Attribute::typesFields(),
        ]);
    }
}
