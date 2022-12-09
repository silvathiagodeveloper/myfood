<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface PlanRepositoryInterface extends BaseRepositoryInterface
{
    public function getByUrl(string $url);

    public function search(string $fiter = null, int $qty = 15);
}