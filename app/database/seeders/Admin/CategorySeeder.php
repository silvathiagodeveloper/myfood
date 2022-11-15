<?php

namespace Database\Seeders\Admin;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(10)->create();
    }
}
