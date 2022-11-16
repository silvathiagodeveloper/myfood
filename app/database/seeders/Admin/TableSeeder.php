<?php

namespace Database\Seeders\Admin;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Table::factory(10)->create();
    }
}
