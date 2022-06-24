<?php

namespace App\Providers;

use App\Repositories\BrasileiraoJogosRepository;
use App\Repositories\BrasileiraoRepository;
use App\Repositories\Contracts\BrasileiraoJogosRepositoryInterface;
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

        /** Brasileirao Jogos Repository */
        $this->app->bind(BrasileiraoJogosRepositoryInterface::class, BrasileiraoJogosRepository::class);
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
