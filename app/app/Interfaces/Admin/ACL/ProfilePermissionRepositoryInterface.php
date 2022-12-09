<?php

namespace App\Interfaces\Admin\ACL;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Permission;
use App\Models\Admin\Profile;

interface ProfilePermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function getPermissions(Profile $profile);

    public function getPermissionsPaginate(Profile $profile, int $qty = 15, string $filter = null);

    public function attachPermissions(int $id, array $permissions);

    public function detachPermissions(int $id, array $permissions);

    public function getPermissionsAvailable(int $profileId, int $qty = 15, string $filter = null);

    public function getProfilesPaginate(Permission $permissao, int $qty = 15, string $filter = null);
}