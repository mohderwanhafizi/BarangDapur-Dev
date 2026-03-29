<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
    public function boot(): void
    {
       // Paksa HTTPS jika aplikasi berjalan di local (Ngrok) atau production
        if (app()->environment('local', 'production')) {
            URL::forceScheme('https');
        }
    }
}
