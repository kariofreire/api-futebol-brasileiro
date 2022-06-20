<?php

namespace App\Providers;

use App\Repositories\BrasileiraoRepository;
use App\Repositories\Contracts\BrasileiraoRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /** Brasileirao Repository */
        $this->app->bind(BrasileiraoRepositoryInterface::class, BrasileiraoRepository::class);
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
