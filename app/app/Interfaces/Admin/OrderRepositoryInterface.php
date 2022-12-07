<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);
    public function getByUuid(string $uuid);
}