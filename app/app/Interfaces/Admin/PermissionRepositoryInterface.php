<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);

    public function getByProfileId(int $profileId, int $qtty = 15);
}