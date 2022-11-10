<?php

namespace App\Providers;

use App\Interfaces\Admin\ACL\PlanProfileRepositoryInterface;
use App\Interfaces\Admin\ACL\ProfilePermissionRepositoryInterface;
use App\Interfaces\Admin\DetailPlanRepositoryInterface;
use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Interfaces\Admin\PlanRepositoryInterface;
use App\Interfaces\Admin\ProfileRepositoryInterface;
use App\Interfaces\Admin\TenantRepositoryInterface;
use App\Interfaces\Admin\UserRepositoryInterface;
use App\Repositories\Admin\ACL\PlanProfileRepository;
use App\Repositories\Admin\ACL\ProfilePermissionRepository;
use App\Repositories\Admin\DetailPlanRepository;
use App\Repositories\Admin\PermissionRepository;
use App\Repositories\Admin\PlanRepository;
use App\Repositories\Admin\ProfileRepository;
use App\Repositories\Admin\TenantRepository;
use App\Repositories\Admin\UserRepository;
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
        $this->app->bind(PlanProfileRepositoryInterface::class, PlanProfileRepository::class);
        $this->app->bind(TenantRepositoryInterface::class, TenantRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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
