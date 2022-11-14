<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface TenantRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);
}