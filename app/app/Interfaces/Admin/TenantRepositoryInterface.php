<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;
use Brick\Math\BigInteger;

interface TenantRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);
    public function getByUuid(string $uuid);
}