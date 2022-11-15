<?php

namespace App\Services\Tenant;

use App\Models\Admin\Tenant;
use App\Repositories\Admin\TenantRepository;

class TenantManager
{
    public function getTenantId() : int|null
    {
        return session()->get('user')->tenant_id ?? null;
    }

    public function getTenant(): Tenant
    {
        $tenantRep = new TenantRepository();
        return $tenantRep->getById($this->getTenantId());
    }

    public function isAdmin(): bool
    {
        return in_array(session()->get('user')->email ?? null, config('tenant.admins'));
    }
}