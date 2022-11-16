<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Admin\CategorySeeder;
use Database\Seeders\Admin\DetailPlanSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Admin\PlanSeeder;
use Database\Seeders\Admin\ProductSeeder;
use Database\Seeders\Admin\ProfileSeeder;
use Database\Seeders\Admin\TableSeeder;
use Database\Seeders\Admin\TenantSeeder;
use Database\Seeders\Admin\UserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::Environment() === 'local') {
            $this->call(
                [
                    PlanSeeder::class,
                    DetailPlanSeeder::class,
                    ProfileSeeder::class,
                    PermissionSeeder::class,
                    TenantSeeder::class,
                    UserSeeder::class,
                    CategorySeeder::class,
                    ProductSeeder::class,
                    TableSeeder::class
                ]
            );
        }
    }
}
