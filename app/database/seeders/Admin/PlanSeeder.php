<?php

namespace Database\Seeders\Admin;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::create(
            [
                'name'    => 'Business',
                'url'     => 'business',
                'price'   => 149,
                'description' => 'Módulos completos'
            ]
        );
        $plan->profiles()->attach([1]);
        Plan::factory(9)->create();
    }
}
