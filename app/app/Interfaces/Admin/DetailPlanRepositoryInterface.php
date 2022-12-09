<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface DetailPlanRepositoryInterface extends BaseRepositoryInterface
{
    public function search(int $planId, string $filter = null, int $qty = 15);

    public function getAllByPlanId(int $planId, int $qty = 15);
}