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

    public function search(string $filter = null, int $qty = 15) 
    {
        $return = $this->modelName::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        return $return->paginate($qty);
    }
}