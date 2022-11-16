<?php

namespace App\Observers\Admin;

use App\Services\Tenant\TenantManager;
use Illuminate\Database\Eloquent\Model;

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
            $model->tenant_id = $tenantId;
        }
    }
}
