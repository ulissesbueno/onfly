<?php

namespace App\Providers;

use App\Domain\Repositories\TravelOrderRepositoryInterface;
use App\Infrastructure\Repositories\TravelOrderRepository;
use App\OwnerManager\UserOwnerManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserOwnerManager::class, function () {
            return new UserOwnerManager();
        });

        $this->app->bind(TravelOrderRepositoryInterface::class, TravelOrderRepository::class);
        

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
