<?php

namespace App\Providers;

use App\Api\Repositories\Interfaces\NginxRepositoryInterface;
use App\Api\Repositories\Interfaces\VirtualHostRepositoryInterface;
use App\Api\Repositories\NginxRepository;
use App\Api\Repositories\VirtualHostRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(NginxRepositoryInterface::class, NginxRepository::class);
        $this->app->bind(VirtualHostRepositoryInterface::class, VirtualHostRepository::class);
    }
}
