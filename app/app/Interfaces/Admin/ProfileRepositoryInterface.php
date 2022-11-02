<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Profile;

interface ProfileRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);

    public function getPermissions(Profile $profile);

    public function getPermissionsPaginate(Profile $profile, int $qtty = 15);

    public function attachPermissions(int $id, array $permissions);
}