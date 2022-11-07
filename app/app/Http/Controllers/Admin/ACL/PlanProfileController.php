<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\ACL\PlanProfileRepositoryInterface;
use App\Interfaces\Admin\PlanRepositoryInterface;
use App\Interfaces\Admin\ProfileRepositoryInterface;
use Illuminate\Http\Request;

class PLanProfileController extends Controller
{
    private PlanRepositoryInterface $planRepository;
    private ProfileRepositoryInterface $profileRepository;
    private PlanProfileRepositoryInterface $planProfileRepository;

    public function __construct(
        PlanRepositoryInterface $planRepository,
        ProfileRepositoryInterface $profileRepository, 
        PlanProfileRepositoryInterface $planProfileRepository
    ){
        $this->planRepository = $planRepository;
        $this->profileRepository = $profileRepository;
        $this->planProfileRepository = $planProfileRepository;
    }

    public function profiles(int $idPlan)
    {
        $plan = $this->planRepository->getById($idPlan);
        $profiles = $this->planProfileRepository->getProfilesPaginate($plan, config('constants.max_paginate'));

        return view('admin.pages.plans.profiles.index',[
            'plan' => $plan,
            'profiles' => $profiles
        ]);
    }

    public function plans(int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $plans = $this->planProfileRepository->getPlansPaginate($profile, config('constants.max_paginate'));

        return view('admin.pages.plans.profiles.plans',[
            'profile' => $profile,
            'plans' => $plans
        ]);
    }

    public function searchProfiles(Request $request, int $idPlan)
    {
        $plan = $this->planRepository->getById($idPlan);
        $profiles = $this->planProfileRepository->getProfilesPaginate($plan, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.plans.profiles.index',[
            'plan' => $plan,
            'profiles' => $profiles,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function searchPlans(Request $request, int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $plans = $this->planProfileRepository->getPlansPaginate($profile, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.plans.profiles.plans',[
            'profile' => $profile,
            'plans' => $plans,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function profilesAvailable(Request $request, int $idPlan)
    {
        $plan = $this->planRepository->getById($idPlan);
        $profiles = $this->planProfileRepository->getProfilesAvailable($idPlan, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.plans.profiles.create', [
            'plan' => $plan,
            'profiles' => $profiles,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function profilesAttach(Request $request, int $idPlan)
    {
        try {
            $this->planProfileRepository->attachProfiles($idPlan, $request->input('profiles') ?? []);
            return redirect()->route('plans.profiles', $idPlan);
        } catch(EmptyArrayException $err) {
            return redirect()->back()
                             ->withErrors(['Pelo menos uma permissão deve ser selecionada!']);
        }
    }

    public function profilesDetach(int $idPlan, int $idProfile)
    {
        $this->planProfileRepository->detachProfiles($idPlan, [$idProfile]);

        return redirect()->route('plans.profiles', $idPlan);
    }
}