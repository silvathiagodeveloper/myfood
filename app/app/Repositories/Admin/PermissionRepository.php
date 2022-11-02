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
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }

    public function getByProfileId(int $profileId, int $qtty = 15)
    {
        return $this->modelName::whereNotIn('id', function($query) use ($profileId) {
            $query->select('profile_permission.permission_id') 
                  ->from('profile_permission')
                  ->where('profile_permission.profile_id', $profileId);
        })->paginate($qtty);
    }
}