<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Admin\DetailPlanSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Admin\PlanSeeder;
use Database\Seeders\Admin\ProfileSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                //PlanSeeder::class,
                //DetailPlanSeeder::class,
                //ProfileSeeder::class,
                PermissionSeeder::class
            ]
        ); 
    }
}
