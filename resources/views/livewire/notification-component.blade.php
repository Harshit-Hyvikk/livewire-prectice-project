<div wire:teleport="#notification-container">
    <div class="relative">
        <button wire:click="$toggle('showNotifications')" class="relative p-2 text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if(count($notifications) > 0)
                <span
                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">
                    {{ count($notifications) }}
                </span>
            @endif
        </button>

        @if($showNotifications)
            <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border z" wire:transition.opacity.duration.700ms>
                <div class="p-4">
                    <div class=" flex justify-between">

                        <h3 class="text-lg font-semibold mb-4">Notifications</h3>
                        <h3 class="text-lg font-semibold mb-4" wire:click="$toggle('showNotifications')">close</h3>
                    </div>
                    @forelse($notifications as $notification)
                        <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm">{{ $notification->message }}</p>
                            <button wire:click="markAsRead({{ $notification->id }})" class="text-xs text-blue-500 mt-2">
                                Mark as read
                            </button>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No new notifications</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
