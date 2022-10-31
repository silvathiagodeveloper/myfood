<?php

namespace App\Observers;

use App\Models\Admin\Plan;
use Illuminate\Support\Str;

class PlanObserver
{
    /**
     * Handle the Plan "created" event.
     *
     * @param  \App\Models\Admin\Plan  $plan
     * @return void
     */
    public function creating(Plan $plan)
    {
        $plan->url = $this->createUrl($plan->name);
    }

    /**
     * Handle the Plan "updated" event.
     *
     * @param  \App\Models\Admin\Plan  $plan
     * @return void
     */
    public function updating(Plan $plan)
    {
        $plan->url = $this->createUrl($plan->name);
    }

    private function createUrl(string $name) : string
    {
        return Str::kebab($name);
    }
}
