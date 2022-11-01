<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface DetailPlanRepositoryInterface extends BaseRepositoryInterface
{
    public function search(int $planId, string $filter = null, int $qtty = 15);

    public function getAllByPlanId(int $planId, int $qtty = 15);
}