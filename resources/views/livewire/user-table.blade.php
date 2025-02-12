<div>
    <!-- Search and Per Page Selection -->
    <div class="flex justify-between mb-4">
        <div class="w-1/3">
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   class="w-full rounded border-gray-300"
                   placeholder="Search...">
        </div>
        <select wire:model.change="perPage" class="rounded border-gray-300  w-16 p-2">
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
        </select>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')" class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                                <!-- Sort Icons -->
                                @if ($sortField === 'name')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                        <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @endif
                            </button>
                        </div>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left" >
                        <div class="flex items-center" wire:click="sortBy('email')">
                            <button  class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                                @if ($sortField === 'email')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                        <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @endif
                            </button>
                        </div>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <div class="flex items-center">
                            <button wire:click="sortBy('created_at')" class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created At
                                @if ($sortField === 'created_at')
                                    @if ($sortDirection === 'asc')
                                        <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    @else
                                        <svg class="w-3 h-3 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    @endif
                                @endif
                            </button>
                        </div>
                    </th>
                    <th class="px-6 py-3 bg-gray-50">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            <button wire:click="delete({{ $user->id }})" class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>



{{-- <div>
    <!-- Global Search -->
    <div class="mb-4">
        <input
            wire:model.debounce.300ms="search"
            type="text"
            class="form-control"
            placeholder="Global Search..."
        >
    </div>

    <!-- Table with Column Filters -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <!-- Name Column -->
                    <th class="px-6 py-3 bg-gray-50">
                        <div class="flex items-center">
                            <button wire:click="sortBy('name')" class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                                @if ($sortField === 'name')
                                    {!! $sortDirection === 'asc' ? '▲' : '▼' !!}
                                @endif
                            </button>
                            <input
                                wire:model.debounce.300ms="nameSearch"
                                type="text"
                                class="ml-2 form-control form-control-sm"
                                placeholder="Filter Name"
                            >
                        </div>
                    </th>

                    <!-- Email Column -->
                    <th class="px-6 py-3 bg-gray-50">
                        <div class="flex items-center">
                            <button wire:click="sortBy('email')" class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                                @if ($sortField === 'email')
                                    {!! $sortDirection === 'asc' ? '▲' : '▼' !!}
                                @endif
                            </button>
                            <input
                                wire:model.debounce.300ms="emailSearch"
                                type="text"
                                class="ml-2 form-control form-control-sm"
                                placeholder="Filter Email"
                            >
                        </div>
                    </th>

                    <!-- Role Column -->
                    <th class="px-6 py-3 bg-gray-50">
                        <div class="flex items-center">
                            <button wire:click="sortBy('role')" class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                                @if ($sortField === 'role')
                                    {!! $sortDirection === 'asc' ? '▲' : '▼' !!}
                                @endif
                            </button>
                            <select
                                wire:model.live.debounce.300ms="roleSearch"
                                class="ml-2 form-control form-control-sm"
                            >
                                <option value="">All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </th>

                    <!-- Actions Column -->
                    <th class="px-6 py-3 bg-gray-50">
                        <button
                            wire:click="resetFilters"
                            class="btn btn-secondary"
                        >
                            Reset Filters
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <!-- Action buttons -->
                            <button>Edit</button>
                            <button>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div> --}}
