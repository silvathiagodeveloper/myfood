<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\TableRepositoryInterface;
use App\Models\Admin\Table;
use App\Repositories\UrlUuidRepository;

class TableRepository extends UrlUuidRepository implements TableRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Table::class;
    }

    public function search(string $filter = null, int $qty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->paginate($qty);
    }
}