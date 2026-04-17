<?php

namespace App\Providers;

use App\Repositories\Contracts\PegawaiRepositoryInterface;
use App\Repositories\SplpPegawaiRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PegawaiRepositoryInterface::class, SplpPegawaiRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
