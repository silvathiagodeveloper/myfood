<?php

namespace App\Models\Admin;

use App\Models\BaseModel;

class Table extends BaseModel
{
    protected $fillable = [ 'tenant_id', 'name', 'url'];
}
