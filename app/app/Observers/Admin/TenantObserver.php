<?php

namespace App\Observers\Admin;

use App\Observers\UrlObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TenantObserver extends UrlObserver
{
    /**
     * Handle the Tenant "created" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function creating(Model $model)
    {
        $model->uuid = Str::uuid();
        parent::creating($model);
    }
}
