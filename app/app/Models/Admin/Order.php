<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'tenant_id',
        'client_id',
        'table_id',
        'total',
        'status',
        'description'
    ];

    /**
     * Get Tenant
     */
    public function tenants()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get Table
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get Products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
