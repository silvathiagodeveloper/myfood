<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface TenantRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qty = 15);
    public function getByUuid(string $uuid);
}