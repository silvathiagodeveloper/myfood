<?php

namespace App\Interfaces\Admin\ACL;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;

interface RolePermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function getPermissions(Role $role);

    public function getPermissionsPaginate(Role $role, int $qtty = 15, string $filter = null);

    public function attachPermissions(int $id, array $permissions);

    public function detachPermissions(int $id, array $permissions);

    public function getPermissionsAvailable(int $roleId, int $qtty = 15, string $filter = null);

    public function getRolesPaginate(Permission $permissao, int $qtty = 15, string $filter = null);
}