<?php

namespace App\Providers;

use App\Repositories\Contracts\ProdutoRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Core\Eloquent\ProdutoEloquentRepository;
use App\Repositories\Core\Eloquent\UserEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserEloquentRepository::class);
        $this->app->bind(ProdutoRepositoryInterface::class, ProdutoEloquentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
