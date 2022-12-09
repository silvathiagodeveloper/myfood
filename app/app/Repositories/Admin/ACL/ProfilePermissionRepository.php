<?php

namespace App\Repositories\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Interfaces\Admin\ACL\ProfilePermissionRepositoryInterface;
use App\Models\Admin\Permission;
use App\Models\Admin\Profile;
use App\Repositories\BaseRepository;

class ProfilePermissionRepository extends BaseRepository implements ProfilePermissionRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Profile::class;
    }
    public function getPermissions(Profile $profile) 
    {
        return $profile->permissions();
    }

    public function getPermissionsPaginate(Profile $profile, int $qty = 15, string $filter = null) 
    {
        $return = $profile->permissions();
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
        $profile = $this->getById($id);
        $profile->permissions()->attach($permissions);
        return $profile;
    }

    public function detachPermissions(int $id, array $permissions)
    {
        if(count($permissions) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $profile = $this->getById($id);
        $profile->permissions()->detach($permissions);
        return $profile;
    }

    public function getPermissionsAvailable(int $profileId, int $qty = 15, string $filter = null)
    {
        $return = Permission::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        $return = $return->whereNotIn('id', function($q) use ($profileId) {
                                    $q->select('profile_permission.permission_id') 
                                        ->from('profile_permission')
                                        ->where('profile_permission.profile_id', $profileId);
                                });

        return $return->paginate($qty);
    }

    public function getProfilesPaginate(Permission $permission, int $qty = 15, string $filter = null) 
    {
        $return = $permission->profiles();
        if(isset($filter)) {
            $return = $return->where('profiles.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qty);
    }
}