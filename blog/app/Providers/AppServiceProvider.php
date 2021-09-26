<?php

namespace App\Providers;

use App\Article;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //modelのboot関数のテストのため実行しない。observerで実装したい方はifを外してください！(☝︎ ՞ਊ ՞)☝︎
        if (false) {
            Article::observe(\App\Observers\TestObserver::class);
        }
    }
}
