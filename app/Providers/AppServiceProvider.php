<?php

namespace App\Providers;

use App\Models\Evidencia;
use App\Observers\EvidenciaObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Evidencia::observe(EvidenciaObserver::class);
    }
}
