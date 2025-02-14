<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class DashboardComponent extends Component
{
    // Add property to track if table should be shown
    public $readyToLoad = true;

    public function init()
    {
        $this->readyToLoad = true;
        $this->dispatch('show-table');

    }
    public function createNotification()
    {
        // dd(1);
        Notification::create([
            'message' => 'New notification at ' . now()->format('H:i:s'),
            'type' => 'info',
            'read' => false,
        ]);

        $this->dispatch('refreshNotifications');
    }

    public function render()
    {
        return view('livewire.dashboard-component');
    }
}
