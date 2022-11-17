<?php

namespace Shopfolio\Http\Livewire\Tables;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;
use Shopfolio\Repositories\UserRepository;
use WireUi\Traits\Actions;

class CustomersTable extends DataTableComponent
{
    use Actions;

    public string $defaultSortColumn = 'first_name';

    public array $bulkActions = [
        'deleteSelected' => 'Delete',
        'verified' => 'Verified',
    ];

    public array $sortNames = [
        'email_verified_at' => 'Verified',
    ];

    public array $filterNames = [
        'verified' => 'E-mail Verified',
    ];

    public function columns(): array
    {
        return [
            Column::make(__('shopfolio::layout.forms.label.full_name'), 'first_name')
                ->sortable()
                ->searchable(),
            Column::make(__('shopfolio::layout.forms.label.email_subscription'), 'opt_in')->sortable(),
            Column::make(__('shopfolio::layout.forms.label.registered_at'), 'created_at')
                ->addClass('text-right')
                ->sortable(),
        ];
    }

    public function verified()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            (new UserRepository())->makeModel()
                ->newQuery()
                ->whereIn('id', $this->selectedKeys())
                ->update(['email_verified_at' => now()]);

            $this->notification()->success(
                __('shopfolio::components.tables.status.verified'),
                __('shopfolio::components.tables.messages.verified', ['name' => 'customers'])
            );
        }

        $this->selected = [];

        $this->resetAll();
    }

    public function deleteSelected()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            (new UserRepository())->makeModel()
                ->newQuery()
                ->whereIn('id', $this->selectedKeys())
                ->delete();

            $this->notification()->success(
                __('shopfolio::components.tables.status.delete'),
                __('shopfolio::components.tables.messages.delete', ['name' => 'customers'])
            );
        }

        $this->selected = [];

        $this->resetAll();
    }

    public function filters(): array
    {
        return [
            'mailing' => Filter::make(__('shopfolio::layout.forms.label.email_subscription'))
                ->select([
                    '' => __('shopfolio::layout.forms.label.any'),
                    'yes' => __('shopfolio::layout.forms.label.yes'),
                    'no' => __('shopfolio::layout.forms.label.no'),
                ]),
            'verified' => Filter::make(__('shopfolio::layout.forms.label.email_verified'))
                ->select([
                    '' => __('shopfolio::layout.forms.label.any'),
                    'yes' => __('shopfolio::layout.forms.label.yes'),
                    'no' => __('shopfolio::layout.forms.label.no'),
                ]),
        ];
    }

    public function query(): Builder
    {
        return (new UserRepository())->makeModel()->newQuery()
            ->whereHas('roles', function (Builder $query) {
                $query->where('name', config('shopfolio.system.users.default_role'));
            })
            ->when($this->getFilter('search'), fn ($query, $term) => $query->research($term))
            ->when($this->getFilter('mailing'), fn ($query, $active) => $query->where('opt_in', $active === 'yes'))
            ->when($this->getFilter('verified'), fn ($query, $verified) => $verified === 'yes' ? $query->whereNotNull('email_verified_at') : $query->whereNull('email_verified_at'));
    }

    public function rowView(): string
    {
        return 'shopfolio::livewire.tables.rows.customers-table';
    }
}
