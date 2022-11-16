<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = Profile::create(
            [
                'name'    => 'Admin',
                'description' => 'Módulos completos'
            ]
        );
        $profile->permissions()->attach([1,2,3,4,5,6,7,8,9,10,11,12,13,14]);
        Profile::factory(10)->create();
    }
}
