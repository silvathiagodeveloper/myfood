<?php

namespace Database\Seeders\Admin;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::factory(1)->create();
        $product->categories()->attach([1]);
        Product::factory(10)->create();
    }
}
