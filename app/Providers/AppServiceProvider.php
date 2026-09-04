<?php

namespace App\Providers;

use App\Repositories\Contracts\ItemRepositoryInterface;
use App\Repositories\Contracts\ItemTranslationsRepositoryInterface;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\ItemRepository;
use App\Repositories\ItemTranslationsRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            ItemRepositoryInterface::class,
            ItemRepository::class
        );

        $this->app->bind(
            LanguageRepositoryInterface::class,
            LanguageRepository::class
        );

        $this->app->bind(
            ItemTranslationsRepositoryInterface::class,
            ItemTranslationsRepository::class
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
