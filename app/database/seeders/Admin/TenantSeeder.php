<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::create(
            [
                'cnpj'    => '01000000000101',
                'name'    => 'My food',
                'url'     => 'myfood',
                'email'   => 'admin@myfood.com',
                'plan_id' => '1'
            ]
        );
    }
}
