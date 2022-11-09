<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj',
        'name',
        'url',
        'email',
        'plan_id',
        'logo',
        'active',
        'subscription_at',
        'expires_at',
        'subscription_id',
        'subscription_active',
        'subscription_suspended'
    ];

    /**
     * Get Plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get Users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
