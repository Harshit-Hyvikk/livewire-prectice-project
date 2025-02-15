<!-- resources/views/livewire/advanced-table.blade.php -->

@push('extra_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

@endpush
<div>


    <div class="mb-4 space-y-4">
        <!-- Search -->
        <div class="flex justify-between mb-4">
            <div class="flex justify-start gap-x-3">
                <select wire:model.change="perPage" class="rounded border-gray-300  w-16 p-2">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <div class="flex items-center justify-between">
                    <!-- Custom Dropdown Menu -->
                    <div class="relative inline-block text-left" x-data="{ open: @entangle('bulkDropDown') }" x-init="$watch('open', value => @this.set('bulkDropDown', value))">
                        @if($selectedRows)
                        <button class="inline-flex justify-arround items-center space-x-4 px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" id="dropdownButton" aria-expanded="false" wire:click='$toggle("bulkDropDown")'>
                            <i class="fas fa-ellipsis-v"></i> <!-- Vertical 3-dots icon -->
                            <span>Actions</span>
                        </button>
                        @endif

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded shadow-lg z-10" x-show="open" x-cloak @click.outside="open = false">
                            <div class="py-0">
                                <!-- Delete Selected Button -->
                                @if($selectedRows)
                                <button wire:click="bulkDelete" class="block w-full px-4 py-2 text-left text-red-600 hover:bg-red-100 rounded">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Delete Selected ({{ count($selectedRows) }})
                                </button>
                                @endif

                                <!-- Export Selected Button -->
                                @if($selectedRows)
                                <button wire:click="export" class="block w-full px-4 py-2 text-left text-green-600 hover:bg-green-100 rounded">
                                    <i class="fas fa-download mr-2"></i>
                                    Export Selected
                                </button>
                                @endif

                                <!-- Import Section -->
                                {{-- <div class="px-4 py-2">
                    <form wire:submit.prevent="import">
                        <input type="file" wire:model="importFile" class="border p-2 rounded w-full" accept=".csv">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mt-2" wire:loading.attr="disabled">
                            Import
                        </button>
                    </form>
                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-0">
                @if(!empty($searchColumns))
                {{-- <div>
                    <input wire:model.debounce.300ms="search" type="text"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                        placeholder="Search...">
                </div> --}}
                <div class="w-auto sm:w-1/3">
                    <div class="relative">
                        <input wire:model.live.debounce.300ms="search" type="text" class=" w-auto pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Search...">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                @endif
                <!-- Filters -->
                @if(!empty($filterableColumns))

                <div class="relative" x-data="{ open: @entangle('dropdownVisible') }" x-init="$watch('open', value => @this.set('dropdownVisible', value))">
                    <!-- Filter Dropdown Button -->
                    <button class="w-auto border-0 border-gray-300 rounded-md pt-3 px-3 text-gray-700 focus:outline-none focus:ring-0 focus:ring-indigo-300 focus:border-indigo-300 flex justify-between items-center" wire:click='$toggle("dropdownVisible")'>
                        <i class="fas fa-filter"></i>
                        @if(1 > 0)
                        <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">
                            1
                        </span>
                        @endif
                    </button>

                    {{-- @if($dropdownVisible) --}}
                    <div class="absolute right-0 mt-1 w-48 bg-white border border-gray-300 rounded-md shadow-lg z-10" wire:transition.opacity.duration.700ms x-show="open" x-cloak @click.outside="open = false">
                        <div class="px-4 py-2 space-y-4 max-h-96 overflow-y-auto">
                            {{-- @foreach($filterableColumns as $column => $config)
                            <div>
                                <h6 class="text-sm font-medium text-gray-700 mb-2">{{ $config['label'] }}</h6>
                            @if(isset($config['options']))
                            <div class="space-y-2">
                                <!-- "All" option -->
                                <button wire:click="filters.{{ $column }} = ''" class="block text-sm text-gray-700 hover:bg-indigo-100 w-full px-4 py-2 rounded">
                                    All
                                </button>
                                <!-- Filter options -->
                                @foreach($config['options'] as $value => $label)
                                <button wire:click="filters.{{ $column }} = '{{ $value }}'" class="block text-sm text-gray-700 hover:bg-indigo-100 w-full px-4 py-2 rounded">
                                    {{ $label }}
                                </button>
                                @endforeach
                            </div>
                            @else
                            <!-- Text Input for columns without options -->
                            <input wire:model.debounce.300ms="filters.{{ $column }}" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200" placeholder="Search {{ $config['label'] }}">
                            @endif
                        </div>
                        <hr class="my-2 border-gray-200">
                        @endforeach --}}

                        @foreach($filterableColumns as $column => $config)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                {{ $config['label'] }}
                            </label>
                            @if(isset($config['options']))
                            <select wire:model.change="filters.{{ $column }}"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                                <option value="">All</option>
                                @foreach($config['options'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @else
                            <input type="text" wire:model.blur="filters.{{ $column }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- @endif --}}
            </div>

            @endif
        </div>
    </div>


</div>

<div class="overflow-x-auto bg-white shadow-md rounded-lg" id="mytable">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr class="py-3">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <input type="checkbox" wire:model.change="selectAll" class="form-checkbox">
                </th>
                @foreach($columns as $key => $column)
                <th @if(in_array($key, $orderableColumns)) wire:click="sortBy('{{ $key }}')" class="cursor-pointer px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider" @endif class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                    {{ $column['label'] }}
                    @if(in_array($key, $orderableColumns))

                    {!! $sortField === $key ? ($sortDirection === 'asc' ? '<span class=" text-black">↑</span>' : '<span class="text-black">↓</span>') : '↑ ↓' !!}

                    @endif
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($data as $row)
            <tr>
                <td class="px-6 py-3 text-left">
                    <input type="checkbox" wire:model.change="selectedRows" value="{{ $row->id }}" class="form-checkbox">
                </td>
                @foreach($columns as $key => $column)
                <td class="px-6 py-4 whitespace-nowrap">
                    {{-- {!! $this->getColumnValue($row, $key) !!} --}}
                    {{ data_get($row, $key) }}
                </td>
                @endforeach
            </tr>
            {{-- @empty
            <tr>
                <td colspan="{{ count($columns) }}" class="px-6 py-4 text-center">
                    No records found.
                </td>
            </tr> --}}
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $data->links() }}
</div>





@push('script')

@endpush



<!-- Import Results -->
{{-- @if(!empty($importResults))
        <div class="mb-4">
            <h3 class="font-bold">Import Results:</h3>
            <p>Successful: {{ $importResults['success'] }}</p>
<p>Failed: {{ $importResults['failed'] }}</p>
@if(!empty($importResults['errors']))
<div class="mt-2">
    <h4 class="font-bold text-red-600">Errors:</h4>
    <ul class="list-disc pl-4">
        @foreach($importResults['errors'] as $error)
        <li class="text-red-600">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
</div>
@endif --}}



{{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($filterableColumns as $column => $config)
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        {{ $config['label'] }}
</label>
@if(isset($config['options']))
<select wire:model="filters.{{ $column }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
    <option value="">All</option>
    @foreach($config['options'] as $value => $label)
    <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
@else
<input type="text" wire:model.debounce.300ms="filters.{{ $column }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
@endif
</div>
@endforeach
</div> --}}

</div>
