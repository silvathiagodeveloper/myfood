<?php

namespace App\Observers;

use App\Services\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GlobalTenantObserver
{
    /**
     * Handle the Tenant "created" event.
     *
     * @param  \App\Models\Admin\Tenant  $tenant
     * @return void
     */
    public function creating(Model $model)
    {
        $tenantManager = app(TenantManager::class);
        $tenantId = $tenantManager->getTenantId();
        if(isset($tenantId)) {
            $model->tenant_id = $tenantManager->getTenantId();
        }
    }
}
