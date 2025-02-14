<?php

namespace App\Livewire\Ramonrietdijk;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;
use RamonRietdijk\LivewireTables\Actions\Action;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\BooleanColumn;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Columns\ImageColumn;
use RamonRietdijk\LivewireTables\Filters\SelectFilter;
use RamonRietdijk\LivewireTables\Filters\DateFilter;

class RamonrietdijkUserTable extends LivewireTable
{
    protected string $model = User::class;
    // public $table;
    // protected function query(): \Illuminate\Database\Eloquent\Builder
    // {
    //     return User::query();
    // }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),

            ImageColumn::make('Profile Photo', 'profile_photo'),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),

            Column::make('Address', 'address')
                ->sortable()
                ->searchable(),

            Column::make('City', 'city')
                ->sortable()
                ->searchable(),

            Column::make('Country', 'country')
                ->sortable()
                ->searchable(),

            Column::make('Role', 'role')
                ->sortable()
                ->searchable(),

            DateColumn::make('Created At', 'created_at')
                ->sortable()
                ->format('F jS, Y'),

            Column::make('Actions', function (Model $model): string {
                return '<a class="underline text-blue-600" href="/users/'.$model->id.'/edit">Edit</a>';
            })->clickable(false)->asHtml(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Role', 'role')
                ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                    'editor' => 'Editor',
                ]),

            SelectFilter::make('Country', 'country')
                ->options(
                    User::query()->pluck('country', 'country')->unique()->toArray()
                ),

            DateFilter::make('Created At', 'created_at'),
        ];
    }

    public function actions(): array
    {
        return [
            Action::make('Delete', 'delete_selected', function ($models): void {
                $models->each->delete();
            }),
        ];
    }
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('id', 'desc')
            ->setPerPage(10);
    }

    // public function columns(): array
    // {
    //     return [
    //         Column::make('id', 'ID'),
    //         Column::make('name', 'Name')->searchable()->sortable(),
    //         Column::make('email', 'Email')->searchable()->sortable(),
    //         Column::make('created_at', 'Created At')->sortable(),
    //     ];
    // }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query();
    }
}
