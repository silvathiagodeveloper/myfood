<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Admin\PlanRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    private PlanRepositoryInterface $repository;

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->repository = $planRepository;
    }
    public function index()
    {
        $plans = $this->repository->getAllPaginate(6);

        return view('admin.pages.plans.index', [
            'plans' => $plans
        ]);
    }

    public function create()
    {
        return view('admin.pages.plans.create');
    }

    public function store(Request $request) 
    {
        $request->request->add(['url' => Str::kebab($request->input('name'))]);
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
        $this->repository->delete($url);

        return redirect()->route('plans.index');
    }
}
