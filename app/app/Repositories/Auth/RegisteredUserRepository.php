<?php

namespace App\Repositories\Auth;

use App\Interfaces\Auth\RegisteredUserRepositoryInterface;
use App\Repositories\Admin\TenantRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\Hash;

class RegisteredUserRepository implements RegisteredUserRepositoryInterface
{
    public function register(array $data) 
    {
        $tenantRep = new TenantRepository();
        $tenant = $tenantRep->create([
            'name'    => $data['tenantname'],
            'email'   => $data['email'],
            'cnpj'    => $data['cnpj'],
            'plan_id' => $data['plan_id'],
            'subscription_at' => now(),
            'expires_at' => now()->addDays(7),
        ]);

        $userRep = new UserRepository();

        return $userRep->create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'tenant_id' => $tenant->id,
            'password'  => Hash::make( $data['password']),
        ]);
    }
}