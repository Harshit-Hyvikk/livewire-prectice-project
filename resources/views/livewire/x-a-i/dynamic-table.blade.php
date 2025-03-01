{{-- <div>
    <!-- Bulk Actions and Controls -->
    <div class="row mx-2 mb-3">
        <div class="col-auto">
            <select wire:model.live="perPage" class="form-select w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <div class="col-auto">
            @if ($selectAll || count($selectedItems) > 1)
                <div class="" x-data="{ open: @entangle('dropdownVisible') }" x-init="$watch('open', value => @this.set('dropdownVisible', value))">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" aria-expanded="false"
                        wire:click="$toggle('dropdownVisible')">
                        Actions
                    </button>
                    @if ($dropdownVisible)
                        <ul class="dropdown-menu show mt-1" wire:transition.opacity.duration.700ms x-show="open"
                            x-cloak @click.outside="open = false">
                            <li>
                                <button wire:click="bulkDelete" class="dropdown-item text-danger"
                                    onclick="return confirm('Are you sure you want to delete selected items?')"
                                    {{ empty($selectedItems) ? 'disabled' : '' }}>
                                    Delete Selected
                                </button>
                            </li>
                            <li>
                                <button wire:click="export" class="dropdown-item text-success">
                                    Export {{ $selectedItems ? 'Selected' : 'All' }}
                                </button>
                            </li>
                            <li>
                                <button onclick="window.print()" class="dropdown-item text-primary">
                                    Print
                                </button>
                            </li>
                        </ul>
                    @endif
                </div>
            @endif
        </div>
        <div class="col-md-3 ms-auto w-auto">
            <div class="w-auto col-sm-4 ">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5" placeholder="Search..."
                        wire:model.live.debounce.500ms="search">
                    <i
                        class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                </div>
            </div>
        </div>

    </div>


    <div class="position-relative">
        <!-- Table -->
        <div class="table-responsive mx-3 shadow-sm rounded">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">

                    <tr>
                        <th scope="col" class="ps-4">
                            <input type="checkbox" wire:model.change="selectAll" class="form-check-input shadow-none">
                        </th>
                        {{-- @foreach ($columns as $column)
                            <th scope="col" wire:click="sortBy('{{ $column }}')"
                                class="text-uppercase fw-semibold cursor-pointer">
                                {{ str_replace('_', ' ', ucfirst($column)) }}
                                @if ($sortField === $column)
                                    <span class="ms-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                        @endforeach -}}
                        @foreach ($columns as $key => $column)
                            <th @if (in_array($key, $orderable)) wire:click="sortBy('{{ $key }}')" class="cursor-pointer px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider" @endif
                                class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                {{ $column['label'] }}
                                @if (in_array($key, $orderable))
                                    {!! $sortField === $key
                                        ? ($sortDirection === 'asc'
                                            ? '<span class=" text-black">↑</span>'
                                            : '<span class="text-black">↓</span>')
                                        : '↑ ↓' !!}
                                @endif
                            </th>
                        @endforeach
                        <th scope="col" class="fw-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td class="ps-4">
                                <input type="checkbox" wire:model.change="selectedItems" value="{{ $item->id }}"
                                    class="form-check-input shadow-none">
                            </td>
                            @foreach ($columns as $key => $column)
                                <td>{{ data_get($item, $key) }}</td>
                            @endforeach
                            <td class="whitespace-nowrap">
                                <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-primary me-2"
                                    data-bs-toggle="tooltip" title="Edit record">
                                    Edit
                                </button>
                                <button wire:click="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="Delete record">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}" class="text-center text-muted py-4">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $items->links('vendor.livewire.bootstrap') }}
        </div>

        {{-- @if ($loading)
            <div
                class="position-absolute top-0 start-0 w-100 h-100 bg-light bg-opacity-75 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        @endif -}}
    </div>
</div>

@push('extra_css')
    <!-- Print Styles -->
    <style media="print">
        @page {
            size: auto;
            margin: 0mm;
        }

        body {
            margin: 20mm;
        }

        .btn-group,
        .form-control,
        .form-select,
        nav {
            display: none !important;
        }

        .table-responsive {
            overflow: visible !important;
        }

        .table {
            margin-bottom: 0;
            overflow-x: auto;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-pointer:hover {
            color: #0d6efd;
            /* Bootstrap primary color */
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
@endpush --}}


<div>
    <!-- Bulk Actions and Controls -->
    <div class="row mx-2 mb-3">
        <div class="col-auto">
            <select wire:model.live="perPage" class="form-select w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <div class="col-auto">
            @if ($selectAll || count($selectedItems) > 0)
                <div x-data="{ open: @entangle('dropdownVisible') }" x-init="$watch('open', value => @this.set('dropdownVisible', value))">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" aria-expanded="false"
                        wire:click="$toggle('dropdownVisible')">
                        Actions
                    </button>
                    @if ($dropdownVisible)
                        <ul class="dropdown-menu show mt-1" x-show="open" x-cloak @click.outside="open = false">
                            <li>
                                <button wire:click="bulkDelete" class="dropdown-item text-danger"
                                    onclick="return confirm('Are you sure you want to delete selected items?')"
                                    {{ empty($selectedItems) ? 'disabled' : '' }}>
                                    Delete Selected
                                </button>
                            </li>
                            <li>
                                <button wire:click="export" class="dropdown-item text-success">
                                    Export {{ $selectedItems ? 'Selected' : 'All' }}
                                </button>
                            </li>
                            <li>
                                <button onclick="window.print()" class="dropdown-item text-primary">
                                    Print
                                </button>
                            </li>
                        </ul>
                    @endif
                </div>
            @endif
        </div>

        <div class="col-md-3 ms-auto w-auto">
            <div class="position-relative">
                <input type="text" class="form-control ps-5" placeholder="Search..."
                    wire:model.live.debounce.500ms="search">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
            </div>
        </div>
    </div>

    <div class="position-relative">
        <!-- Table -->
        <div class="table-responsive mx-3 shadow-sm rounded">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">
                            <input type="checkbox" wire:model.change="selectAll" class="form-check-input shadow-none">
                        </th>
                        @foreach ($columns as $key => $column)
                            <th wire:click="sortBy('{{ $key }}')" class="cursor-pointer px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                {{ $column['label'] }}
                                @if ($sortField === $key)
                                    <span class="text-black">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <span>↑↓</span>
                                @endif
                            </th>
                        @endforeach
                        <th scope="col" class="fw-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td class="ps-4">
                                <input type="checkbox" wire:model.change="selectedItems" value="{{ $item->id }}"
                                    class="form-check-input shadow-none">
                            </td>
                            @foreach ($columns as $key => $column)
                                <td>{{ $this->formatValue($key, data_get($item, $key)) }}</td>
                            @endforeach
                            <td class="whitespace-nowrap">
                                <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-primary me-2"
                                    data-bs-toggle="tooltip" title="Edit record">
                                    Edit
                                </button>
                                <button wire:click="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="Delete record">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}" class="text-center text-muted py-4">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 mx-3">
            {{ $items->links('vendor.livewire.bootstrap') }}
        </div>
    </div>
</div>

@push('extra_css')
    <style media="print">
        @page {
            size: auto;
            margin: 0mm;
        }

        body {
            margin: 20mm;
        }

        .btn-group,
        .form-control,
        .form-select,
        nav {
            display: none !important;
        }

        .table-responsive {
            overflow: visible !important;
        }

        .table {
            margin-bottom: 0;
            overflow-x: auto;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .cursor-pointer:hover {
            color: #0d6efd;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
