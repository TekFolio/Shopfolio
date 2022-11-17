<?php

namespace Shopfolio\Http\Livewire\Tables;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Shopfolio\Repositories\Ecommerce\BrandRepository;
use WireUi\Traits\Actions;

class BrandsTable extends DataTableComponent
{
    use Actions;

    public string $defaultSortColumn = 'name';

    public $columnSearch = [
        'name' => null,
    ];

    public array $bulkActions = [
        'deleteSelected' => 'Delete',
        'enabled' => 'Enable',
        'disabled' => 'Disable',
    ];

    public function boot()
    {
        $this->queryString['columnSearch'] = ['except' => null];
    }

    public function columns(): array
    {
        return [
            Column::make(__('shopfolio::layout.forms.label.name'))
                ->sortable()
                ->searchable(),
            Column::make(__('shopfolio::layout.forms.label.website'))->sortable(),
            Column::make(__('shopfolio::layout.forms.label.url'), 'slug')->sortable(),
            Column::make(__('shopfolio::layout.forms.label.updated_at'), 'updated_at')
                ->sortable(),
        ];
    }

    public function deleteSelected()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            (new BrandRepository())->makeModel()
                ->newQuery()
                ->whereIn('id', $this->selectedKeys())
                ->delete();

            $this->notification()->success(
                __('shopfolio::components.tables.status.delete'),
                __('shopfolio::components.tables.messages.delete', ['name' => 'brands'])
            );
        }

        $this->selected = [];

        $this->resetAll();
    }

    public function enabled(): void
    {
        if ($this->selectedRowsQuery->count() > 0) {
            (new BrandRepository())->makeModel()
                ->newQuery()
                ->whereIn('id', $this->selectedKeys())
                ->update(['is_enabled' => true]);

            $this->notification()->success(
                __('shopfolio::components.tables.status.updated'),
                __('shopfolio::components.tables.messages.enabled', ['name' => 'brands'])
            );
        }

        $this->selected = [];

        $this->resetBulk();
    }

    public function disabled(): void
    {
        if ($this->selectedRowsQuery->count() > 0) {
            (new BrandRepository())->makeModel()
                ->newQuery()
                ->whereIn('id', $this->selectedKeys())
                ->update(['is_enabled' => false]);

            $this->notification()->success(
                __('shopfolio::components.tables.status.updated'),
                __('shopfolio::components.tables.messages.disabled', ['name' => 'brands'])
            );
        }

        $this->resetBulk();
    }

    public function query(): Builder
    {
        return (new BrandRepository())->makeModel()->newQuery()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'));
    }

    public function rowView(): string
    {
        return 'shopfolio::livewire.tables.rows.brands-table';
    }
}
