<?php

namespace Database\Seeders\Admin;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'tenant_id' => 1,
                'name' => 'admin',
                'email' => 'admin@e2.com.br',
                'email_verified_at' => '2022-11-08',
                'password' => bcrypt('123456')
            ]
        );
    }
}
