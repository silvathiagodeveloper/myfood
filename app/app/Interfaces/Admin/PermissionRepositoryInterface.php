<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Permission;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);

    public function getByProfileId(int $profileId, int $qtty = 15, string $filter = null);

    public function getProfilesPaginate(Permission $permissao, int $qtty = 15, string $filter = null);
}