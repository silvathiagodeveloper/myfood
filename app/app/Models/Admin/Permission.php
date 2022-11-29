<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function scopeFilter($q, $filter) 
    {
        return $q->where('name', 'LIKE', "%{$filter}%")
                 ->orWhere('description','LIKE', "%{$filter}%");
    }

    /**
     * Get Profiles
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_permission');
    }

    /**
     * Get Roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}
