<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\URL;

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
    public function boot(Router $router) 
    { 

        $router->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class); 

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }


}
