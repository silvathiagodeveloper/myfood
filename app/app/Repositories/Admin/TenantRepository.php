<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\TenantRepositoryInterface;
use App\Models\Admin\Tenant;
use App\Repositories\BaseRepository;

class TenantRepository extends BaseRepository implements TenantRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Tenant::class;
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('cnpj','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }
}