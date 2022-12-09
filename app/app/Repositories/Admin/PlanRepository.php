<?php

namespace App\Repositories\Admin;

use App\Exceptions\PlanWithDetailsException;
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

    public function search(string $filter = null, int $qty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qty);
    }

    public function delete(int $id) 
    {
        $plan = $this->modelName::with('details')
                        ->where('id',$id)
                        ->first();
        if($plan->details->count() == 0) {
            return $plan->delete();
        } 
        
        throw new PlanWithDetailsException('Não é possível apagar planos com detalhes!');
    }
}