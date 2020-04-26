<?php

namespace App\Providers;


use App\repositories\StatRepository;
use App\repositories\StatRepositoryInterface;
use App\services\StatService;
use App\services\StatServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StatServiceInterface::class, StatService::class);
        $this->app->bind(StatRepositoryInterface::class, StatRepository::class);
    }
}
