<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PlanWithDetailsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUpdatePlanRequest;
use App\Interfaces\Admin\PlanRepositoryInterface;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    private PlanRepositoryInterface $repository;

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->repository = $planRepository;
    }
    public function index()
    {
        $plans = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.plans.index', [
            'plans' => $plans
        ]);
    }

    public function search(Request $request)
    {
        $plans = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.plans.index', [
            'plans' => $plans,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.plans.create');
    }

    public function store(StoreUpdatePlanRequest $request) 
    {
        $model = $this->repository->create($request->all());

        return redirect()->route('plans.index');
    }

    public function show($url) 
    {
        $plan = $this->repository->getByUrl($url);
        return view('admin.pages.plans.show',[
            'plan' => $plan
        ]);
    }

    public function destroy($url) 
    {
        try {
            $this->repository->delete($url);

            return redirect()->route('plans.index');
            
        } catch(PlanWithDetailsException $err) {

            return redirect()->back()
                             ->withErrors([$err->getMessage()]);
        }
    }

    public function edit($url) 
    {
        $plan = $this->repository->getByUrl($url);

        return view('admin.pages.plans.edit',[
            'plan' => $plan
        ]);
    }

    public function update(StoreUpdatePlanRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('plans.index');
    }
}
