<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Repositories\Admin\PermissionRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissionnRep = new PermissionRepository();
        $permissions = $permissionnRep->getAll();

        foreach($permissions as $permission) {
            Gate::define($permission->name, function(User $user) use ($permission) {
                return $user->hasPermission($permission->name);
            });
        }

        Gate::before(function(User $user) {
            if($user->isAdmin()) {
                return true;
            }
        });
    }
}
