<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\DetailPlanRepositoryInterface;
use App\Models\Admin\DetailPlan;
use App\Repositories\BaseRepository;

class DetailPlanRepository extends BaseRepository implements DetailPlanRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = DetailPlan::class;
    }

    public function search(int $planId, string $filter = null, int $qty = 15) 
    {
        return $this->modelName::planId($planId)
                    ->latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->paginate($qty);
    }

    public function getAllByPlanId(int $planId, int $qty = 15)
    {
        return $this->modelName::planId($planId)->paginate($qty);
    }
}