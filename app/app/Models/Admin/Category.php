<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory;

    protected $fillable = [ 'tenant_id', 'name', 'url','description'];

    public function scopeFilter($q, $filter) 
    {
        return $q->where('name', 'LIKE', "%{$filter}%")
                 ->orWhere('description','LIKE', "%{$filter}%");
    }
}
