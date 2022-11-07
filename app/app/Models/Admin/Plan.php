<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'price', 'description'];

    public function scopeFilter($q, $filter) 
    {
        return $q->where('name', 'LIKE', "%{$filter}%")
                 ->orWhere('description','LIKE', "%{$filter}%");
    }

    public function details()
    {
        return $this->hasMany(DetailPlan::class);
    }

    /**
     * Get Profiles
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'plan_profile');
    }
}
