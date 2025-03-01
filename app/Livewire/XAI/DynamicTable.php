<?php

namespace App\Livewire\XAI;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

// class DynamicTable extends Component
// {
//     use WithPagination;

//     public $model;          // Model class name
//     public $columns;       // Array of column names to display
//     public $search = '';   // Search term
//     public $perPage = 10;  // Items per page
//     public $sortField = 'id'; // Default sort field
//     public $sortDirection = 'desc'; // Default sort direction
//     public $showFilters = false; // Show/hide filters
//     protected $queryString = [
//         'search' => ['except' => ''],
//         'perPage' => ['except' => 10],
//         'filters' => ['except' => []],
//         'showFilters' => ['except' => false],
//         'sortField' => ['except' => ''],
//         'sortDirection' => ['except' => 'asc'],
//     ];
//     public $columnFormats = [];
//     public $selectedItems = []; // For bulk actions
//     public $searchable = [];    // Searchable columns
//     public $orderable = [];     // Orderable columns
//     public $filterable = [];   // Filterable columns
//     public $filters = [];
//     public $selectAll = false;
//     public $dropdownVisible = false;
//     protected $formatters = [
//         'date' => [self::class, 'formatDate'],
//         'uppercase' => [self::class, 'formatUppercase'],
//         'currency' => [self::class, 'formatCurrency'],
//     ];

//     public function mount($model, $columns = null, $columnFormats = [])
//     {
//         $this->model = $model;
//         $this->columns = $columns;
//         $this->columnFormats = $columnFormats;

//         // If columns not specified, get all columns from model table
//         if (!$columns) {
//             $this->columns = Schema::getColumnListing((new $model)->getTable());
//         } else {
//             $this->columns = $columns;
//         }

//     }

//     public function updatingSearch()
//     {
//         $this->resetPage();
//     }

//     public function sortBy($field)
//     {
//         if ($this->sortField === $field) {
//             $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
//         } else {
//             $this->sortField = $field;
//             $this->sortDirection = 'asc';
//         }
//     }

//     public function updatedSelectAll($value)
//     {

//         if ($value) {
//             // Select all items on the current page
//             $this->selectedItems = $this->getCurrentPageItems()->pluck('id')->toArray();
//         } else {
//             $this->selectedItems = [];
//         }
//     }

//     public function updatedSelectedItems()
//     {
//         // Check if all items on the current page are selected
//         $currentPageIds = $this->getCurrentPageItems()->pluck('id')->toArray();
//         $this->selectAll = count(array_intersect($currentPageIds, $this->selectedItems)) === count($currentPageIds);
//     }

//     public function bulkDelete()
//     {
//         dd($this->selectedItems);
//         $this->model::whereIn('id', $this->selectedItems)->delete();
//         $this->selectedItems = [];
//         $this->selectAll = false;
//     }

//     public function export()
//     {
//         $data = $this->selectedItems ?
//             $this->model::whereIn('id', $this->selectedItems)->get() :
//             $this->getQuery()->get();

//         return Excel::download(
//             new GenericExport($data, $this->columns),
//             'table_export_' . now()->format('Y-m-d') . '.xlsx'
//         );
//     }

//     // Formatter methods
//     public function formatDate($value)
//     {
//         return $value instanceof \Carbon\Carbon ? $value->format('Y-m-d') : $value;
//     }

//     public function formatUppercase($value)
//     {
//         return strtoupper($value);
//     }

//     public function formatValue($column, $value)
//     {
//         if (isset($this->columnFormats[$column]) && isset($this->formatters[$this->columnFormats[$column]])) {
//             return call_user_func($this->formatters[$this->columnFormats[$column]], $value);
//         }
//         return $value;
//     }
//     public function formatCurrency($value)
//     {
//         return '$' . number_format($value, 2);
//     }
//     private function getQuery()
//     {
//         $query = $this->model::query();

//         if ($this->search) {
//             $query->where(function ($query) {
//                 foreach ($this->columns as $column) {
//                     $query->orWhere($column, 'like', '%' . $this->search . '%');
//                 }
//             });
//         }

//         return $query->orderBy($this->sortField, $this->sortDirection);
//     }

//     public function getCurrentPageItems()
//     {
//         return $this->getQuery()
//             ->paginate($this->perPage);
//     }

//     public function render()
//     {

//         $items = $this->getCurrentPageItems();
//         // dd($items);

//         return view('livewire.x-a-i.dynamic-table', [
//             'items' => $items,
//         ]);
//     }
// }






// use Livewire\Component;
// use Livewire\WithPagination;
// use Illuminate\Support\Facades\Schema;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\GenericExport;


class DynamicTable extends Component
{
    use WithPagination;

    public $model;
    public $columns;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $showFilters = false;
    public $columnFormats = [];
    public $selectedItems = [];
    public $searchable = [];
    public $orderable = [];
    public $filterable = [];
    public $filters = [];
    public $selectAll = false;
    public $dropdownVisible = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'filters' => ['except' => []],
        'showFilters' => ['except' => false],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => 'asc'],
    ];

    protected $formatters = [
        'date' => [self::class, 'formatDate'],
        'uppercase' => [self::class, 'formatUppercase'],
        'currency' => [self::class, 'formatCurrency'],
    ];

    public function mount($model, $columns = null, $columnFormats = [], $searchable = [], $orderable = [], $filterable = [])
    {
        $this->model = $model;
        $this->columnFormats = $columnFormats;
        $this->searchable = $searchable;
        $this->orderable = $orderable;
        $this->filterable = $filterable;

        $this->columns = $this->formatColumns($columns ?? Schema::getColumnListing((new $model)->getTable()));

        // Set orderable to all columns by default if not specified
        if (empty($this->orderable)) {
            $this->orderable = array_keys($this->columns);
        }

        // Ensure sortField is valid
        if (!array_key_exists($this->sortField, $this->columns)) {
            $this->sortField = array_keys($this->columns)[0] ?? 'id';
        }

        // $this->resetSelections();
    }

    private function formatColumns($columns)
    {
        $formattedColumns = [];
        if (is_array($columns)) {
            foreach ($columns as $key => $value) {
                if (is_string($value)) {
                    // Array of strings: ['id', 'name']
                    $formattedColumns[$value] = ['label' => ucfirst(str_replace('_', ' ', $value))];
                } elseif (is_array($value) && isset($value['name'])) {
                    // Array with 'name': [['name' => 'id', 'label' => 'ID']]
                    $formattedColumns[$value['name']] = [
                        'label' => $value['label'] ?? ucfirst(str_replace('_', ' ', $value['name']))
                    ];
                } elseif (is_array($value) && isset($value['label'])) {
                    // Associative array: ['id' => ['label' => 'ID']]
                    $formattedColumns[$key] = [
                        'label' => $value['label']
                    ];
                } else {
                    throw new \Exception('Invalid column format');
                }
            }
        }
        return $formattedColumns;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function hydrate()
    {
        $this->resetSelections();
    }



    public function sortBy($field)
    {
        if (in_array($field, $this->orderable)) {
            if ($this->sortField === $field) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortField = $field;
                $this->sortDirection = 'asc';
            }
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->getCurrentPageItems()->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $currentPageIds = $this->getCurrentPageItems()->pluck('id')->toArray();
        $this->selectAll = count(array_intersect($currentPageIds, $this->selectedItems)) === count($currentPageIds);
    }

    public function bulkDelete()
    {
        $this->model::whereIn('id', $this->selectedItems)->delete();
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function export()
    {
        $data = $this->selectedItems ?
            $this->model::whereIn('id', $this->selectedItems)->get() :
            $this->getQuery()->get();

        return Excel::download(
            new GenericExport($data, array_keys($this->columns)),
            'table_export_' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function formatDate($value)
    {
        // dd($value);
        $value = Carbon::parse($value)->format('d-m-Y');
        return $value;
    }

    public function formatUppercase($value)
    {
        return strtoupper($value);
    }

    public function formatCurrency($value)
    {
        return '$' . number_format($value, 2);
    }

    public function formatValue($column, $value)
    {
        // dump($column, isset($this->columnFormats[$column]) && isset($this->formatters[$this->columnFormats[$column]]));
        if (isset($this->columnFormats[$column]) && isset($this->formatters[$this->columnFormats[$column]])) {
            return call_user_func($this->formatters[$this->columnFormats[$column]], $value);
        }
        return $value;
    }

    private function getQuery()
    {
        $query = $this->model::query();

        if ($this->search && !empty($this->searchable)) {
            $query->where(function ($query) {
                foreach ($this->searchable as $column) {
                    if (array_key_exists($column, $this->columns)) {
                        $query->orWhere($column, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        // Apply filters if set
        if (!empty($this->filters)) {
            foreach ($this->filters as $field => $value) {
                if ($value && array_key_exists($field, $this->filterable)) {
                    if ($field === 'created_at') {
                        // Example: Handle date range filter
                        if (is_array($value) && isset($value['start']) && isset($value['end'])) {
                            $query->whereBetween($field, [$value['start'], $value['end']]);
                        }
                    } elseif (isset($this->filterable[$field]['options'])) {
                        $query->where($field, $value);
                    }
                }
            }
        }

        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    public function getCurrentPageItems()
    {
        return $this->getQuery()->paginate($this->perPage);
    }

    public function resetSelections()
    {
        $this->selectAll = false;
        $this->selectedItems = [];
        $this->dropdownVisible = false; // Optionally hide dropdown too
    }

    public function render()
    {
        $items = $this->getCurrentPageItems();

        return view('livewire.x-a-i.dynamic-table', [
            'items' => $items,
        ]);
    }
}
