<?php

namespace App\Providers;

use App\Facades\Cart;
use App\Models\City;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.app', function ($view) {
            $view->with([
                'districts' => City::all()->groupBy('district'),
                'cart' => Cart::instance(),
            ]);
        });
    }
}
