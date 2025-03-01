<?php

use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

use Livewire\Volt\Volt;
Volt::route('/volt-product', 'volt-product')->name('volt.product');

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    // ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('xai/dashboard', function () {
    return view('livewire.xai-dashboard');
})->name('xai.dashboard');
Route::get('xai/d2', function () {
    return view('livewire.xai-d2');
})->name('xai.d2');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::get('component/filament/pagination', Dashboard::class)
    // ->middleware(['auth'])
    ->name('components.filament.pagination');

require __DIR__ . '/auth.php';
