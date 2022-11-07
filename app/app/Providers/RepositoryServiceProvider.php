<?php

namespace App\Providers;

use App\Interfaces\Admin\ACL\ProfilePermissionRepositoryInterface;
use App\Interfaces\Admin\DetailPlanRepositoryInterface;
use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Interfaces\Admin\PlanRepositoryInterface;
use App\Interfaces\Admin\ProfileRepositoryInterface;
use App\Repositories\Admin\ACL\ProfilePermissionRepository;
use App\Repositories\Admin\DetailPlanRepository;
use App\Repositories\Admin\PermissionRepository;
use App\Repositories\Admin\PlanRepository;
use App\Repositories\Admin\ProfileRepository;
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
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(ProfilePermissionRepositoryInterface::class, ProfilePermissionRepository::class);
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
