<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDetailPlanRequest;
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
        $details = $this->repository->getAllByPlanId($plan->id,config('constants.max_paginate'));

        return view('admin.pages.plans.details.index',[
            'plan' => $plan,
            'details' => $details
        ]);
    }

    public function search(Request $request, string $urlPlan)
    {
        $plan = $this->planRepository->getByUrl($urlPlan);
        $details = $this->repository->search($plan->id,$request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.plans.details.index', [
            'plan' => $plan,
            'details' => $details,
            'filters' => $filters
        ]);
    }

    public function show($urlPlan, int $id)
    {
        $plan = $this->planRepository->getByUrl($urlPlan);
        $detail = $this->repository->getById($id);

        return view('admin.pages.plans.details.show',[
            'plan' => $plan,
            'detail' => $detail
        ]);
    }

    public function create($urlPlan)
    {
        $plan = $this->planRepository->getByUrl($urlPlan);

        return view('admin.pages.plans.details.create',[
            'plan' => $plan
        ]);
    }

    public function store(StoreUpdateDetailPlanRequest $request, string $url)
    {
        $plan = $this->planRepository->getByUrl($url);

        $request->request->add(['plan_id' => $plan->id]);
        $this->repository->create($request->all());

        return redirect()->route('details.plans.index',$url);
    }

    public function edit($urlPlan, int $id)
    {
        $plan = $this->planRepository->getByUrl($urlPlan);
        $detail = $this->repository->getById($id);

        return view('admin.pages.plans.details.edit',[
            'plan' => $plan,
            'detail' => $detail
        ]);
    }

    public function update(StoreUpdateDetailPlanRequest $request, $urlPlan, int $id)
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('details.plans.index',$urlPlan);
    }

    public function destroy($urlPlan, int $id) 
    {
        $this->repository->delete($id);

        return redirect()
            ->route('details.plans.index', $urlPlan)
            ->with(config('constants.array_messages'),['Registro apagado com sucesso!']);
    }
}
