<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(
            [
                'name'    => 'Admin',
                'description' => 'Módulos completos'
            ]
        );
        $role->permissions()->attach([1,2,3,4,5,6,7,8,9,10,11,12,13,14]);
        Role::factory(10)->create();
    }
}
