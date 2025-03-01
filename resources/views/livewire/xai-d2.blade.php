<!-- In any view -->
@extends('layouts.custome')

@section('content')
    <!-- In a Blade view -->
<div>
    <h1 class="text-2xl font-bold mb-6">User Management</h1>

    @livewire('x-a-i.d2', [
        'model' => 'App\Models\User',
        'columns' => [
            'id',
            'name',
            'email',
            'created_at',
            // 'profile.bio',  // Relationship column
            // 'posts.title'   // Relationship column
        ],
        'formats' => [
            // 'created_at' => fn($value) => $value ? $value->format('d-m-Y') : '-',
            // 'profile.bio' => fn($value) => $value ? substr($value, 0, 20) . '...' : '-',
            // 'posts.title' => fn($value, $item) => $item->posts->first()->title ?? '-',
        ],
        'relationships' => [ 'posts'],
        'customSearch' => function ($query, $search, $visibleColumns) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            })
            ->orWhereHas('profile', function ($q) use ($search) {
                $q->where('bio', 'like', "%$search%");
            })
            ->orWhereHas('posts', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        },
        'showActions' => true
    ])
</div>
@endsection
