<!-- In any view -->
@extends('layouts.custome')

@section('content')
    @php
        $columnFormats = [
            'created_at' => function ($value) {
                return $value->format('Y-m-d');
            },
            'email' => function ($value) {
                return strtoupper($value);
            },
        ];
    @endphp
    {{-- <livewire:x-a-i.dynamic-table :model="\App\Models\User::class" :columns="['id', 'name', 'email','created_at']" :column-formats="[
        'created_at' => 'date',
        'email' => 'uppercase',
    ]"
    :searchable="['name', 'email']"
    :orderable ="['id', 'name', 'email', 'created_at']"
    :filterable = "[
        'role' => [
            'label' => 'Role',
            'options' => [
                'admin' => 'Admin',
                'user' => 'User',
            ]
        ],
        'created_at' => [
            'label' => 'Date Range',
        ],
    ]"/> --}}

    @livewire('x-a-i.dynamic-table', [
        'model' => \App\Models\User::class,
        'columns' => [
            'id' => ['label' => 'ID'],
            'name' => ['label' => 'Name'],
            'email' => ['label' => 'Email'],
            'created_at' => ['label' => 'Created'],
        ],
        'searchable' => ['name', 'email'],
        'columnFormats' => [
            'created_at' => 'date',
            // 'email' => 'uppercase',
        ],
        'orderable' => ['id', 'name', 'email', 'created_at'],
        'filterable' => [
            'role' => [
                'label' => 'Role',
                'options' => [
                    'admin' => 'Admin',
                    'user' => 'User',
                ],
            ],
            'created_at' => [
                'label' => 'Date Range',
            ],
        ],
    ])
@endsection
