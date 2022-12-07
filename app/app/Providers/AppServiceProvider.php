<?php

namespace App\Providers;

use App\Models\Admin\Category;
use App\Models\Admin\Plan;
use App\Models\Admin\Product;
use App\Models\Admin\Table;
use App\Models\Admin\Tenant;
use App\Observers\UuidObserver;
use App\Observers\UrlObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        Plan::observe(UrlObserver::class);
        Tenant::observe([UrlObserver::class, UuidObserver::class]);
        Category::observe([UrlObserver::class, UuidObserver::class]);
        Product::observe([UrlObserver::class, UuidObserver::class]);
        Table::observe([UrlObserver::class, UuidObserver::class]);
    }
}
