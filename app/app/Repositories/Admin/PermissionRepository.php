<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Models\Admin\Permission;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Permission::class;
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        $return = $this->modelName::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        return $return->paginate($qtty);
    }

    public function getByProfileId(int $profileId, int $qtty = 15, string $filter = null)
    {
        $return = $this->modelName::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        $return = $return->whereNotIn('id', function($q) use ($profileId) {
                                    $q->select('profile_permission.permission_id') 
                                        ->from('profile_permission')
                                        ->where('profile_permission.profile_id', $profileId);
                                });

        return $return->paginate($qtty);
    }

    public function getProfilesPaginate(Permission $permission, int $qtty = 15, string $filter = null) 
    {
        $return = $permission->profiles();
        if(isset($filter)) {
            $return = $return->where('profiles.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qtty);
    }
}