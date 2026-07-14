<?php

namespace App\Providers;

use App\Services\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Cart::class, fn () => new Cart());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Expose the live cart item count to every view (used in the navbar).
        View::composer('*', function ($view) {
            $view->with('cartCount', app(Cart::class)->count());
        });
    }
}
