<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    public $roleSearch="";
    public $nameSearch="";
    public $emailSearch="";

    // Listen for events
    protected $listeners = ['refreshTable' => '$refresh'];

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Sort function
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function resetFilters(){
        $this->roleSearch="";
        $this->nameSearch="";
        $this->emailSearch="";
    }

    public function render()
    {
        return view('livewire.user-table', [
            'users' => User::search($this->search)
                ->when($this->roleSearch,function($query){
                    $query->where('role','like',$this->roleSearch);
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
}
