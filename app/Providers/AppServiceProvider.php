<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Routing\Router;
use Spatie\Permission\Middleware\RoleMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Puedes registrar otros bindings aquí si los necesitas
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        // Alias para el middleware 'role'
        $router->aliasMiddleware('role', RoleMiddleware::class);

        // Forzar HTTPS y usar build en producción
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
            Vite::useBuildDirectory('build');
        }
    }
}
