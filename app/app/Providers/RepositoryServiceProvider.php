<?php

namespace App\Providers;

use App\Interfaces\Admin\DetailPlanRepositoryInterface;
use App\Interfaces\Admin\PlanRepositoryInterface;
use App\Repositories\Admin\DetailPlanRepository;
use App\Repositories\Admin\PlanRepository;
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
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(DetailPlanRepositoryInterface::class, DetailPlanRepository::class);
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
