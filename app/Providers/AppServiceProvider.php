<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//JWT Imports
use Illuminate\Routing\Router; // Import Router
use App\Http\Middleware\JWTMiddleware; // Import Middleware
use App\Services\JWTService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(JWTService::class, function ($app) {
            return new JWTService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        // Register the middleware
        $router->aliasMiddleware('jwt.auth', JWTMiddleware::class);
    }
}
