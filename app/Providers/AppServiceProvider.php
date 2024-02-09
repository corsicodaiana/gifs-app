<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Repositories\LogRequestRepositoryInterface;
use Infrastructure\Repositories\LogRequestRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            LogRequestRepositoryInterface::class,
            LogRequestRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
