<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Actividad;
use App\Observers\ActividadObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        \App\Arquitectura\Interfaces\MercadoLaboral::class,
        \App\Arquitectura\Clases\EstudioClase::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Log::info('✅ AppServiceProvider boot ejecutado');
        Actividad::observe(ActividadObserver::class);
    }
}
