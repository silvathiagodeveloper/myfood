<?php

namespace App\Models\Admin;

use App\Models\BaseModel;

class Category extends BaseModel
{
    protected $fillable = [ 'tenant_id', 'name', 'url','description', 'uuid'];

    public function scopeFilter($q, $filter) 
    {
        return $q->where('name', 'LIKE', "%{$filter}%")
                 ->orWhere('description','LIKE', "%{$filter}%");
    }

    /**
     * Get Products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
