<?php

namespace App\Repositories\Admin;

use App\Exceptions\EmptyArrayException;
use App\Interfaces\Admin\ProfileRepositoryInterface;
use App\Models\Admin\Profile;
use App\Repositories\BaseRepository;
use Exception;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Profile::class;
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }

    public function getPermissions(Profile $profile) 
    {
        return $profile->permissions();
    }

    public function getPermissionsPaginate(Profile $profile, int $qtty = 15, string $filter = null) 
    {
        $return = $profile->permissions();
        if(isset($filter)) {
            $return = $return->where('permissions.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qtty);
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
}