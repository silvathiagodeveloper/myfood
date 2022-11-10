<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\PlanRepository;

class SiteController extends Controller
{
    public function index()
    {
        $plansRep = new PlanRepository();
        $detailPlansRep = new PlanRepository();
        $plans = $plansRep->getAll(['price'],['details']);
        return view('site.pages.home.index', [
            'plans' => $plans
        ]);
    }

    public function plan(string $url)
    {
        $planRep = new PlanRepository();
        $plan = $planRep->getByUrl($url);

        session()->put('plan',$plan);

        return redirect()->route('register');
    }
}