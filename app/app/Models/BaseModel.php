<?php

namespace App\Models;

use App\Observers\GlobalTenantObserver;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::observe(GlobalTenantObserver::class);
        static::addGlobalScope(new TenantScope);
    }
}