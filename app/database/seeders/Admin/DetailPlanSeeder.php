<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\DetailPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetailPlan::factory(10)->create();
    }
}
