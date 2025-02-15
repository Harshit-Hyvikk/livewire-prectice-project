<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class LivewireUsersDataTable extends DataTableComponent
{
    protected $model = User::class;



    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setPerPageAccepted([10, 25, 50])
            ->setDefaultSort('created_at', 'desc')
            ->setFilterPillsEnabled()
            ->setEmptyMessage('No users found')
            ->setTableWrapperAttributes([
                'default' => false,
                'class' => 'overflow-x-auto',
            ])
            ->setTableAttributes([
                'default-color' => false,
                'default-colors' => false,
                'default-styling' => false,
                'class' => 'min-w-full divide-y divide-gray-200',
            ])

            ->setTheadAttributes([
                'default' => false,
                'class' => 'bg-gray-100 overflow-x-auto',
            ])
            ->setTbodyAttributes([
                'default' => false,
                'class' => 'bg-gray-50 divide-y overflow-x-auto',
            ])
            ->setTrAttributes(function ($row) {
                return [
                    'default' => false,
                    'default-colors' => false,
                    'default-styling' => false,
                    'class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-500 bg-gray-50',
                ];
            })
            ->setThAttributes(function ($row) {
                return [
                    'default' => false,
                    'class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase',
                ];
            })
            ->setTdAttributes(function ($row) {
                return [
                    'default' => false,
                    'class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-500',
                ];
            })
            ->setTableWrapperAttributes([
                'default' => false,
                'default-colors' => false,
                'default-styling' => false,
                'class' => 'overflow-x-auto',
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable()->searchable(),
            Column::make("Name", "name")
                ->sortable()->searchable(),
            Column::make("Email", "email")
                ->sortable()->searchable(),
            Column::make("Profile photo", "profile_photo"),
            Column::make("Phone", "phone")
                ->sortable()->searchable(),
            Column::make("Address", "address")
                ->sortable()->searchable(),
            Column::make("City", "city")
                ->sortable()->searchable(),
            Column::make("Country", "country")
                ->sortable(),
            Column::make("Role", "role")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
