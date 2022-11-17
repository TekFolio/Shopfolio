<?php

namespace Shopfolio\Http\Livewire\Tables;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Shopfolio\Repositories\Ecommerce\CollectionRepository;
use WireUi\Traits\Actions;

class CollectionsTable extends DataTableComponent
{
    use Actions;

    public string $defaultSortColumn = 'name';

    public $columnSearch = [
        'name' => null,
    ];

    public array $bulkActions = [
        'deleteSelected' => 'Delete',
    ];

    public array $filterNames = [
        'type' => 'Type',
    ];

    public function deleteSelected()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            (new CollectionRepository())->makeModel()->newQuery()->whereIn('id', $this->selectedKeys())->delete();

            $this->notification()->success(
                __('shopfolio::components.tables.status.delete'),
                __('shopfolio::components.tables.messages.delete', ['name' => 'collections'])
            );
        }

        $this->selected = [];

        $this->resetAll();
    }

    public function filters(): array
    {
        return [
            'type' => Filter::make(__('shopfolio::pages/collections.filter_type'))
                ->select([
                    '' => __('shopfolio::layout.forms.label.any'),
                    'auto' => __('shopfolio::pages/collections.automatic'),
                    'manual' => __('shopfolio::pages/collections.manual'),
                ]),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make(__('shopfolio::layout.forms.label.name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('shopfolio::layout.forms.label.type'), 'type')->sortable(),
            Column::make(__('shopfolio::pages/collections.product_conditions')),
            Column::make(__('shopfolio::layout.forms.label.updated_at'), 'updated_at')
                ->sortable(),
        ];
    }

    public function query(): Builder
    {
        return (new CollectionRepository())->makeModel()->newQuery()
            ->with('rules')
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->when($this->getFilter('type'), fn ($query, $type) => $query->where('type', $type));
    }

    public function rowView(): string
    {
        return 'shopfolio::livewire.tables.rows.collections-table';
    }
}
