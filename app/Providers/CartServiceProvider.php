<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\CartService::class, function ($app) {
            return new \App\Services\CartService(
                new \App\Storages\DBStorage,
                $app['events'],
                'cart',
                session()->getId(),
                config('shopping_cart'),
            );
        });
    }
}
