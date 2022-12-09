<?php

namespace App\Interfaces\Admin\ACL;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\User;
use App\Models\Admin\Role;

interface UserRoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getRoles(User $user);

    public function getRolesPaginate(User $user, int $qty = 15, string $filter = null);

    public function attachRoles(int $id, array $roles);

    public function detachRoles(int $id, array $roles);

    public function getRolesAvailable(int $UserId, int $qty = 15, string $filter = null);

    public function getUsersPaginate(Role $role, int $qty = 15, string $filter = null);
}