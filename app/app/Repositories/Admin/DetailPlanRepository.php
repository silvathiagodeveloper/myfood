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

    public function search(int $planId, string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::where('plan_id', $planId)
                    ->where('name','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }

    public function getAllByPlanId(int $planId, int $qtty = 15)
    {
        return $this->modelName::where('plan_id',$planId)->paginate($qtty);
    }
}