<?php

namespace App\Providers;

use App\Models\Admin\Category;
use App\Models\Admin\Plan;
use App\Models\Admin\Product;
use App\Models\Admin\Tenant;
use App\Observers\CategoryObserver;
use App\Observers\PlanObserver;
use App\Observers\ProductObserver;
use App\Observers\TenantObserver;
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
        Plan::observe(PlanObserver::class);
        Tenant::observe(TenantObserver::class);
        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
    }
}
