<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'plan_id'];
    protected $table = 'details_plan';

    public function scopePlanId($q, $planId) 
    {
        return $q->where('plan_id', $planId);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}