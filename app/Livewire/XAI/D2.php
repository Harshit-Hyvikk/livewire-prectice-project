<?php

namespace App\Livewire\XAI;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

class D2 extends Component
{
    use WithPagination;

    public $model;          // Model class name
    public $columns;       // Array of column names to display
    public $search = '';   // Search term
    public $perPage = 10;  // Items per page
    public $sortField = 'id'; // Default sort field
    public $sortDirection = 'desc'; // Default sort direction
    public $showFilters = false; // Show/hide filters
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'filters' => ['except' => []],
        'showFilters' => ['except' => false],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => 'asc'],
    ];
    public $columnFormats = [];
    public $selectedItems = []; // For bulk actions
    public $searchable = [];    // Searchable columns
    public $orderable = [];     // Orderable columns
    public $filterable = [];   // Filterable columns
    public $filters = [];
    public $selectAll = false;
    public $dropdownVisible = false;
    protected $formatters = [
        'date' => [self::class, 'formatDate'],
        'uppercase' => [self::class, 'formatUppercase'],
        'currency' => [self::class, 'formatCurrency'],
    ];

    public function mount($model, $columns = null, $columnFormats = [])
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->columnFormats = $columnFormats;

        // If columns not specified, get all columns from model table
        if (!$columns) {
            $this->columns = Schema::getColumnListing((new $model)->getTable());
        } else {
            $this->columns = $columns;
        }

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // Select all items on the current page
            $this->selectedItems = $this->getCurrentPageItems()->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        // Check if all items on the current page are selected
        $currentPageIds = $this->getCurrentPageItems()->pluck('id')->toArray();
        $this->selectAll = count(array_intersect($currentPageIds, $this->selectedItems)) === count($currentPageIds);
    }

    public function bulkDelete()
    {
        dd($this->selectedItems);
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
            new GenericExport($data, $this->columns),
            'table_export_' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    // Formatter methods
    public function formatDate($value)
    {
        return $value instanceof \Carbon\Carbon ? $value->format('Y-m-d') : $value;
    }

    public function formatUppercase($value)
    {
        return strtoupper($value);
    }

    public function formatValue($column, $value)
    {
        if (isset($this->columnFormats[$column]) && isset($this->formatters[$this->columnFormats[$column]])) {
            return call_user_func($this->formatters[$this->columnFormats[$column]], $value);
        }
        return $value;
    }
    public function formatCurrency($value)
    {
        return '$' . number_format($value, 2);
    }
    private function getQuery()
    {
        $query = $this->model::query();

        if ($this->search) {
            $query->where(function ($query) {
                foreach ($this->columns as $column) {
                    $query->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection);
    }

    public function getCurrentPageItems()
    {
        return $this->getQuery()
            ->paginate($this->perPage);
    }

    public function render()
    {

        $items = $this->getCurrentPageItems();
        // dd($items);

        return view('livewire.x-a-i.dynamic-table', [
            'items' => $items,
        ]);
    }
}
