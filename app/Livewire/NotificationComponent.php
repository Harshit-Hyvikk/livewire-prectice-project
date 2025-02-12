<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationComponent extends Component
{
    public $notifications = [];
    public $showNotifications = false;

    protected $listeners = ['refreshNotifications' => 'getNotifications'];

    public function mount()
    {
        $this->getNotifications();
    }

    public function getNotifications()
    {
        $this->notifications = Notification::where('read', false)
            ->latest()
            ->take(5)
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        $notification->update(['read' => true]);
        $this->getNotifications();
    }

    public function render()
    {
        return view('livewire.notification-component');
    }

}
