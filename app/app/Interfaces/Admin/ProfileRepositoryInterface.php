<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface ProfileRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qty = 15);
}