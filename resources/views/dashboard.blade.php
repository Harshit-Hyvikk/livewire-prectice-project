<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-y-visible shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative flex justify-between me-10 h-auto">
                        <livewire:dashboard-component />
                        <livewire:notification-component />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-12">
        <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg max-w-full  mx-auto sm:px-6 lg:p-8">
            @livewire('advanced-table', [
            'modelName' => \App\Models\User::class,
            'columns' => [
            'id' => ['label' => 'ID'],
            'name' => ['label' => 'Name'],
            'email' => ['label' => 'Email'],
            'created_at' => ['label' => 'Created'],
            ],
            'searchable' => ['name', 'email'],
            'orderable' => ['id', 'name', 'email', 'created_at'],
            'filterable' => [
            'role' => [
            'label' => 'Role',
            'options' => [
            'admin' => 'Admin',
            'user' => 'User'
            ]
            ],
            'created_at' => [
            'label' => 'Date Range',
            ]
            ]
            ])
        </div>
    </div>



    {{-- filament livewire table --}}
    {{-- @livewire('data-table') --}}

    {{-- ramonrietdijk livewire table  --}}
    {{-- @livewire('ramonrietdijk.ramonrietdijk-user-table') --}}

    {{-- custome simple livewire table  model ScopSearch required--}}
    {{-- <livewire:user-table /> --}}



    {{-- custome livewire table --}}
    {{-- @livewire('advanced-table', [
    'config' => [
    'model' => App\Models\User::class,
    'columns' => [
    'id' => [
    'label' => 'ID',
    ],
    'name' => [
    'label' => 'Name',
    'format' => fn($row) => "<span class='font-bold'>{$row->name}</span>"
    ],
    'email' => [
    'label' => 'Email'
    ],
    // 'status' => [
    // 'label' => 'Status',
    // 'format' => fn($row) => view('components.status-badge', ['status' => $row->status])->render()
    // ],
    'created_at' => [
    'label' => 'Created',
    'format' => fn($row) => $row->created_at->format('Y-m-d')
    ]
    ],
    'searchable' => ['name', 'email'],
    'orderable' => ['id', 'name', 'email', 'created_at'],
    'filterable' => [
    // 'status' => [
    // 'label' => 'Status',
    // 'options' => [
    // 'active' => 'Active',
    // 'inactive' => 'Inactive'
    // ]
    // ],
    'role' => [
    'label' => 'Role',
    'options' => [
    'admin' => 'Admin',
    'user' => 'User'
    ],
    'query' => function ($query, $value) {
    return $query->whereHas('roles', function ($q) use ($value) {
    $q->where('name', $value);
    });
    }
    ],
    'created_at' => [
    'label' => 'Date Range',
    'query' => function ($query, $value) {
    return $query->whereDate('created_at', '>=', $value);
    }
    ]
    ]
    ]
    ]) --}}

    {{-- @livewire('advanced-table', [
    'modelName' => \App\Models\User::class,
    'columns' => [
    'id' => ['label' => 'ID'],
    'name' => ['label' => 'Name'],
    'email' => ['label' => 'Email'],
    'created_at' => ['label' => 'Created'],
    ],
    'searchable' => ['name', 'email'],
    'orderable' => ['id', 'name', 'email', 'created_at'],
    'filterable' => [
    'role' => [
    'label' => 'Role',
    'options' => [
    'admin' => 'Admin',
    'user' => 'User'
    ]
    ],
    'created_at' => [
    'label' => 'Date Range',
    ]
    ]
    ]) --}}



    {{-- <div class="flex justify-center items-center p-4"> --}}
    {{-- Rappasoft livewire table console error not solvable script also required --}}
    {{-- <livewire:livewire-users-data-table /> --}}
    {{-- @push('script')
            <script>
                document.addEventListener("alpine:init", () => {
                    Alpine.data("laravellivewiretable", ($wire) => ({
                        shouldBeDisplayed: true, // Ensure this is true
                    }));
                });

            </script>
            @endpush --}}
    {{-- </div> --}}

</x-app-layout>
