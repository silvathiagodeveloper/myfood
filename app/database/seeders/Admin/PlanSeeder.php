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
        Plan::factory(3)->create();
    }
}
