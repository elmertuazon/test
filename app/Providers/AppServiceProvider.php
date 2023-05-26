<?php

namespace App\Providers;

use App\Models\Post;
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
            $postsByMonth = Post::selectRaw("
            count(*) as post_count,
            YEAR(MIN(publish_at)) as post_year,
            LPAD(MONTH(MIN(publish_at)), 2, '0') as post_month,
            MONTHNAME(MIN(publish_at)) as post_month_name
        ")
                ->published()
                ->accepted()
                ->groupByRaw("YEAR(publish_at), MONTH(publish_at)")
                ->orderByRaw("YEAR(publish_at) DESC, MONTH(publish_at) DESC")
                ->get();

            $view->with('postsByMonth', $postsByMonth);
        });
    }
}
