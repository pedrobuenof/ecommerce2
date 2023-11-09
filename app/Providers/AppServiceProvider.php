<?php

namespace App\Providers;

use App\Repositories\Interfaces\UserRepositorieInterface;
use App\Repositories\UserRepositorie;
use App\Services\CreateUserService;
use App\UseCases\CreateUserInterface;
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
        $this->app->bind(CreateUserInterface::class, CreateUserService::class);

        $this->app->bind(UserRepositorieInterface::class, UserRepositorie::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
