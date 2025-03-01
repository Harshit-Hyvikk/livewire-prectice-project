<div>
    <div class="py-4">
        <div class="flex justify-between">
            <div class="w-1/3">
                <input wire:model.debounce.300ms="search" type="text" placeholder="Search..."
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <select wire:model="perPage" class="px-4 py-2 border rounded-lg">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($columns as $column)
                        <th wire:click="sortBy('{{ $column }}')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                            {{ str_replace('.', ' ', ucfirst(str_replace('_', ' ', $column))) }}

                            @if($sortField === $column)
                                @if($sortDirection === 'asc')
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @endif
                            @endif
                        </th>
                    @endforeach

                    @if($showActions)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($items as $item)
                    <tr>
                        @foreach($columns as $column)
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $this->formatValue($item, $column) }}
                            </td>
                        @endforeach

                        @if($showActions)
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('users.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </a>
                                <button wire:click="deleteRecord({{ $item->id }})"
                                    onclick="return confirm('Are you sure you want to delete this record?')"
                                    class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach

                @if($items->count() === 0)
                    <tr>
                        <td colspan="{{ count($columns) + ($showActions ? 1 : 0) }}" class="px-6 py-4 text-center text-gray-500">
                            No records found.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="py-4">
        {{ $items->links() }}
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
</div>
