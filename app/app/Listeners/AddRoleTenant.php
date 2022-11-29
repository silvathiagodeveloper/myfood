<?php

namespace App\Listeners;

use App\Events\TenantCreated;
use App\Repositories\Admin\ACL\UserRoleRepository;
use App\Repositories\Admin\RoleRepository;

class AddRoleTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TenantCreated $event)
    {
        $user = $event->user();
        $roleRep = new RoleRepository();
        $role = $roleRep->first(['id']);
        $userRoleRep = new UserRoleRepository();
        $userRoleRep->attachRoles($user->id,[$role->id]);
    }
}
