<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\RoleRepositoryInterface;
use App\Models\Admin\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Role::class;
    }

    public function search(string $filter = null, int $qty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qty);
    }
}