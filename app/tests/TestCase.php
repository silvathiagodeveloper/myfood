<?php

namespace Tests;

use App\Models\Admin\Plan;
use App\Models\Admin\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function auth() {
        return $this->createUser('user@e2.com.br');
    }

    protected function authAdmin() {
        return $this->createUser('admin@e2.com.br');
    }

    private function createUser(string $email) : User {
        $plan = Plan::factory(1)->create();
        $tenant = Tenant::factory(1)->create(['plan_id' => $plan[0]->id]);
        $user = User::factory(1)->create(
            [
                'tenant_id' => $tenant[0]->id, 
                'email' => $email
            ]);
        return $user[0];
    }
}
