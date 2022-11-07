<?php

namespace App\Interfaces\Admin\ACL;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Plan;
use App\Models\Admin\Profile;

interface PlanProfileRepositoryInterface extends BaseRepositoryInterface
{
    public function getProfiles(Plan $plan);

    public function getProfilesPaginate(Plan $plan, int $qtty = 15, string $filter = null);

    public function attachProfiles(int $id, array $profiles);

    public function detachProfiles(int $id, array $profiles);

    public function getProfilesAvailable(int $PlanId, int $qtty = 15, string $filter = null);

    public function getPlansPaginate(Profile $profile, int $qtty = 15, string $filter = null);
}