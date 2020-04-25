<?php

namespace App\Providers;


use App\Http\repositories\StatRepository;
use App\Http\repositories\StatRepositoryInterface;
use App\Http\services\StatService;
use App\Http\services\StatServiceInterface;
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
