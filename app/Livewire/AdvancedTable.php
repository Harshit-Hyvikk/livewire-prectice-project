<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;

class AdvancedTable extends Component
{
    use WithPagination;

    public $model;
    public $columns = [];
    public $searchColumns = [];
    public $orderableColumns = [];
    public $filterableColumns = [];

    // Filters and Search
    public $filters = [];
    public $search = '';

    // Sorting
    public $sortField = 'id';
    public $sortDirection = 'desc';

    // Pagination
    public $perPage = 10;

    // protected $queryString = ['sortField', 'sortDirection', 'search', 'filters'];

    // public function mount($config)
    // {
    //     $this->model = $config['model'];
    //     $this->columns = $config['columns'];
    //     $this->searchColumns = $config['searchable'] ?? [];
    //     $this->orderableColumns = $config['orderable'] ?? [];
    //     $this->filterableColumns = $config['filterable'] ?? [];

    //     // Initialize filters
    //     foreach ($this->filterableColumns as $column => $options) {
    //         $this->filters[$column] = '';
    //     }
    // }

    public function sortBy($field)
    {
        if (!in_array($field, $this->orderableColumns)) {
            return;
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function getColumnValue($row, $column)
    {
        if (isset($this->columns[$column]['format'])) {
            return $this->columns[$column]['format']($row);
        }

        return data_get($row, $column);
    }

    // public function render()
    // {
    //     $query = $this->model::query();

    //     // Apply search if provided
    //     if ($this->search && !empty($this->searchColumns)) {
    //         $query->where(function($q) {
    //             foreach ($this->searchColumns as $column) {
    //                 $q->orWhere($column, 'like', '%' . $this->search . '%');
    //             }
    //         });
    //     }

    //     // Apply filters
    //     foreach ($this->filters as $column => $value) {
    //         if ($value !== '' && isset($this->filterableColumns[$column])) {
    //             $filterConfig = $this->filterableColumns[$column];

    //             if (isset($filterConfig['query'])) {
    //                 $query = $filterConfig['query']($query, $value);
    //             } else {
    //                 $query->where($column, $value);
    //             }
    //         }
    //     }

    //     // Apply sorting
    //     if (in_array($this->sortField, $this->orderableColumns)) {
    //         $query->orderBy($this->sortField, $this->sortDirection);
    //     }

    //     $data = $query->paginate($this->perPage);

    //     return view('livewire.advanced-table', [
    //         'data' => $data
    //     ]);
    // }


    public $modelName;
    // public $columns = [];
    // public $searchColumns = [];
    // public $orderableColumns = [];
    // public $filterableColumns = [];

    public $data1;
    public $selectedRows = []; // Holds the selected row IDs
    public $selectAll = false; // Master checkbox state


    // public $filters = [];
    // public $search = '';
    // public $sortField = 'id';
    // public $sortDirection = 'desc';
    // public $perPage = 10;
    public $dropdownVisible = false;
    public $bulkDropDown = false;

    // protected $queryString = ['sortField', 'sortDirection', 'search', 'filters'];

    public function mount($modelName, $columns, $searchable = [], $orderable = [], $filterable = [])
    {
        $this->modelName = $modelName;
        $this->columns = $columns;
        $this->searchColumns = $searchable;
        $this->orderableColumns = $orderable;
        $this->filterableColumns = $filterable;

        foreach ($this->filterableColumns as $column => $options) {
            $this->filters[$column] = '';
        }
    }

    public function updatedSelectAll($value)
    {

        if ($value) {

            $this->selectedRows = collect($this->data1)->pluck('id')->toArray();
        } else {

            $this->selectedRows = [];
        }
    }

    public function updatedSelectedRows()
    {
        if (sizeof($this->selectedRows) === sizeof($this->data1)) {
            $this->selectAll = true; // Select "Select All" checkbox if all are selected
        } else {
            $this->selectAll = false; // Deselect "Select All" checkbox if not all are selected
        }
    }

    public function getModel()
    {
        return app($this->modelName);
    }



    public function formatColumnValue($row, $column)
    {
        $value = data_get($row, $column);

        // Handle specific column formatting
        switch ($column) {
            case 'created_at':
                return $value ? $value->format('Y-m-d') : '';

            case 'name':
                return "<span class='font-bold'>{$value}</span>";

                // Add more cases for other columns as needed

            default:
                return $value;
        }
    }

    // public function applyFilter($query, $column, $value)
    // {
    //     $column=strtolower($column);
    //     switch ($column) {
    //         // case 'role':
    //         //     return $query->whereHas('roles', function ($q) use ($value) {
    //         //         $q->where('name', $value);
    //         //     });

    //         case 'created_at':
    //             return $query->whereDate('created_at', '>=', $value);


    //         default:
    //             return $query->where($column, $value);
    //     }
    // }


    public function closeDropdown()
    {
        $this->dropdownVisible = false;
    }

    public function bulkDelete()
    {
        if (empty($this->selectedRows)) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Please select items to delete'
            ]);
            return;
        }

        try {
            $model = $this->getModel();
            $model::whereIn('id', $this->selectedRows)->delete();

            $this->selectedRows = [];
            $this->selectAll = false;

            $this->dispatchBrowserEvent('notify', [
                'type' => 'success',
                'message' => 'Selected items have been deleted successfully'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Error deleting items: ' . $e->getMessage()
            ]);
        }
    }

    public function render($data = null)
    {
        $query = $this->getModel()::query();

        // Apply search
        if ($this->search && !empty($this->searchColumns)) {
            $query->where(function ($q) {
                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Apply filters
        // foreach ($this->filters as $column => $value) {
        //     if ($value !== '' && isset($this->filterableColumns[$column])) {
        //         $query = $this->applyFilter($query, $column, $value);
        //     }
        // }



        foreach ($this->filters as $column => $value) {
            if ($value !== '' && isset($this->filterableColumns[$column])) {
                $query->where($column, $value);
            }
        }


        // foreach ($this->filters as $column => $value) {
        //     $query->when(
        //         $value !== '' && isset($this->filterableColumns[$column]), // condition
        //         function ($q) use ($column, $value) {
        //             $filterConfig = $this->filterableColumns[$column];

        //             if (isset($filterConfig['query'])) {
        //                 // Apply the custom filter query
        //                 return $filterConfig['query']($q, $value);
        //             } else {
        //                 // Apply the default `where` condition
        //                 return $q->Where($column, $value);
        //             }
        //         }
        //     );
        // }

        // Apply sorting
        if (in_array($this->sortField, $this->orderableColumns)) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }


        $data = $query->paginate($this->perPage);
        $this->data1 = $data->items();
        // dd($this->data1);


        return view('livewire.advanced-table', [
            'data' => $data
        ]);
        // return view('livewire.advanced-table');
    }

    public function applyFilter()
    {
        $this->resetPage();
        $this->render();
    }
}
