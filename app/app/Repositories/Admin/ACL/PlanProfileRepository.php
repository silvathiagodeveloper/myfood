<?php

namespace App\Repositories\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Interfaces\Admin\ACL\PlanProfileRepositoryInterface;
use App\Models\Admin\Plan;
use App\Models\Admin\Profile;
use App\Repositories\BaseRepository;

class PlanProfileRepository extends BaseRepository implements PlanProfileRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Plan::class;
    }
    public function getProfiles(Plan $plan) 
    {
        return $plan->profiles();
    }

    public function getProfilesPaginate(Plan $plan, int $qtty = 15, string $filter = null) 
    {
        $return = $plan->profiles();
        if(isset($filter)) {
            $return = $return->where('profiles.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qtty);
    }

    public function attachProfiles(int $id, array $profiles)
    {
        if(count($profiles) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $plan = $this->getById($id);
        $plan->profiles()->attach($profiles);
        return $plan;
    }

    public function detachProfiles(int $id, array $profiles)
    {
        if(count($profiles) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $plan = $this->getById($id);
        $plan->profiles()->detach($profiles);
        return $plan;
    }

    public function getProfilesAvailable(int $planId, int $qtty = 15, string $filter = null)
    {
        $return = Profile::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        $return = $return->whereNotIn('id', function($q) use ($planId) {
                                    $q->select('plan_profile.profile_id') 
                                        ->from('plan_profile')
                                        ->where('plan_profile.plan_id', $planId);
                                });

        return $return->paginate($qtty);
    }

    public function getPlansPaginate(Profile $profile, int $qtty = 15, string $filter = null) 
    {
        $return = $profile->plans();
        if(isset($filter)) {
            $return = $return->where('plans.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qtty);
    }
}