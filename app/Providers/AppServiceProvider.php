<?php

namespace App\Providers;

use App\Services\ApiService;
use App\Services\RegionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiService::class, static function (): ApiService {
            return new ApiService();
        });

        $this->app->singleton(RegionService::class, static function (): RegionService {
            return new RegionService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
