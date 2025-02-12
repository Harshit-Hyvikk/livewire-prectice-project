<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class DashboardComponent extends Component
{
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
