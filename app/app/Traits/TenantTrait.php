<?php

namespace App\Traits;

use App\Observers\Admin\GlobalTenantObserver;
use App\Scopes\TenantScope;

trait TenantTrait
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::observe(GlobalTenantObserver::class);
        static::addGlobalScope(new TenantScope);
    }
}