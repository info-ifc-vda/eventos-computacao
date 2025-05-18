<?php

namespace App\Providers;

use App\Http\Services\Contracts\EventServiceInterface;
use App\Http\Services\EventService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EventServiceInterface::class,
            EventService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
