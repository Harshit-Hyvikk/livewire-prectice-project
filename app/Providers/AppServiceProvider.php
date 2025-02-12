<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FilamentColor::register([
        //     'primary' => Color::Amber,
        //     'gray' => Color::Gray,
        //     'info' => Color::Blue,
        //     'success' => Color::Green,
        //     'warning' => Color::Orange,
        //     'danger' => Color::Red,
        // ]);
    }
}
