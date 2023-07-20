<?php

namespace App\Providers;

use App\Models\Post;
use App\Utils\SidebarQueryProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer('layouts._sidebar', function ($view) {
            $postsByMonth = app()->environment('testing')
                ? SidebarQueryProvider::forSqlite()
                : SidebarQueryProvider::forMysql();

            $view->with('postsByMonth', $postsByMonth);
        });
    }
}
