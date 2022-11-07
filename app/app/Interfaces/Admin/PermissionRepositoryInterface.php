<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Permission;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);
}