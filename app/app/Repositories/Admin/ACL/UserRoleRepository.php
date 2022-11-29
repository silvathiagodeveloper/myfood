<?php

namespace App\Repositories\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Interfaces\Admin\ACL\UserRoleRepositoryInterface;
use App\Models\User;
use App\Models\Admin\Role;
use App\Repositories\BaseRepository;

class UserRoleRepository extends BaseRepository implements UserRoleRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = User::class;
    }
    public function getRoles(User $user) 
    {
        return $user->roles();
    }

    public function getRolesPaginate(User $user, int $qtty = 15, string $filter = null) 
    {
        $return = $user->roles();
        if(isset($filter)) {
            $return = $return->where('roles.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qtty);
    }

    public function attachRoles(int $id, array $roles)
    {
        if(count($roles) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $user = $this->getById($id);
        $user->roles()->attach($roles);
        return $user;
    }

    public function detachRoles(int $id, array $roles)
    {
        if(count($roles) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $user = $this->getById($id);
        $user->roles()->detach($roles);
        return $user;
    }

    public function getRolesAvailable(int $userId, int $qtty = 15, string $filter = null)
    {
        $return = Role::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        $return = $return->whereNotIn('id', function($q) use ($userId) {
                                    $q->select('user_role.role_id') 
                                        ->from('user_role')
                                        ->where('user_role.user_id', $userId);
                                });

        return $return->paginate($qtty);
    }

    public function getUsersPaginate(Role $role, int $qtty = 15, string $filter = null) 
    {
        $return = $role->users();
        if(isset($filter)) {
            $return = $return->where('users.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qtty);
    }
}