<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\PlanRepositoryInterface;
use App\Models\Admin\Plan;
use App\Repositories\BaseRepository;

class PlanRepository extends BaseRepository implements PlanRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Plan::class;
    }

    public function getByUrl(string $url) 
    {
        return $this->modelName::where('url',$url)->firstOrFail();
    }
}