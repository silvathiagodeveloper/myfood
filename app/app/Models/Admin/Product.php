<?php

namespace App\Models\Admin;

use App\Models\BaseModel;

class Product extends BaseModel
{
    protected $fillable = ['tenant_id', 'name', 'url', 'price', 'description', 'image', 'uuid'];

    public function scopeFilter($q, $filter) 
    {
        return $q->where('name', 'LIKE', "%{$filter}%")
                 ->orWhere('description','LIKE', "%{$filter}%");
    }

    /**
     * Get Categories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
