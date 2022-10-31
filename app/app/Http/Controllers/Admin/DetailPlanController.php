<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\DetailPlanRepositoryInterface;
use App\Interfaces\Admin\PlanRepositoryInterface;
use Illuminate\Http\Request;

class DetailPlanController extends Controller
{
    protected DetailPlanRepositoryInterface $repository;
    protected PlanRepositoryInterface $planRepository;
    public function __construct(DetailPlanRepositoryInterface $detailPlanRepository, PlanRepositoryInterface $planRepository)
    {
        $this->repository = $detailPlanRepository;
        $this->planRepository = $planRepository;
    }

    public function index($urlPlan)
    {
        $plan = $this->planRepository->getByUrl($urlPlan);
        $details = $plan->details()->paginate();

        return view('admin.pages.plans.details.index',[
            'plan' => $plan,
            'details' => $details
        ]);
    }

    public function create($urlPlan)
    {
        $plan = $this->planRepository->getByUrl($urlPlan);

        return view('admin.pages.plans.details.create',[
            'plan' => $plan
        ]);
    }

    public function store(Request $request, string $url)
    {
        $plan = $this->planRepository->getByUrl($url);

        $request->request->add(['plan_id' => $plan->id]);
        $this->repository->create($request->all());

        return redirect()->route('details.plans.index',$url);
    }
}
