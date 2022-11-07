<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function scopeFilter($q, $filter) 
    {
        return $q->where('name', 'LIKE', "%{$filter}%")
                 ->orWhere('description','LIKE', "%{$filter}%");
    }

    /**
     * Get Permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'profile_permission');
    }

    /**
     * Get Plans
     */
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_profile');
    }
}
