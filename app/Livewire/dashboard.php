<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Notification;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    public int|string $perPage = 10;

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::query()->paginate($this->perPage);
        return view('livewire.dashboard', compact('users'))->layout('layouts.app');
    }
}
