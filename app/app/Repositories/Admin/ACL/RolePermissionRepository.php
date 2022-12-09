<?php

namespace App\Repositories\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Interfaces\Admin\ACL\RolePermissionRepositoryInterface;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Repositories\BaseRepository;

class RolePermissionRepository extends BaseRepository implements RolePermissionRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Role::class;
    }
    public function getPermissions(Role $role) 
    {
        return $role->permissions();
    }

    public function getPermissionsPaginate(Role $role, int $qty = 15, string $filter = null) 
    {
        $return = $role->permissions();
        if(isset($filter)) {
            $return = $return->where('permissions.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qty);
    }

    public function attachPermissions(int $id, array $permissions)
    {
        if(count($permissions) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $role = $this->getById($id);
        $role->permissions()->attach($permissions);
        return $role;
    }

    public function detachPermissions(int $id, array $permissions)
    {
        if(count($permissions) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $role = $this->getById($id);
        $role->permissions()->detach($permissions);
        return $role;
    }

    public function getPermissionsAvailable(int $roleId, int $qty = 15, string $filter = null)
    {
        $return = Permission::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        $return = $return->whereNotIn('id', function($q) use ($roleId) {
                                    $q->select('role_permission.permission_id') 
                                        ->from('role_permission')
                                        ->where('role_permission.role_id', $roleId);
                                });

        return $return->paginate($qty);
    }

    public function getRolesPaginate(Permission $permission, int $qty = 15, string $filter = null) 
    {
        $return = $permission->roles();
        if(isset($filter)) {
            $return = $return->where('roles.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qty);
    }
}