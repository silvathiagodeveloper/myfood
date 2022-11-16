<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\TableRepositoryInterface;
use App\Models\Admin\Table;
use App\Repositories\BaseRepository;

class TableRepository extends BaseRepository implements TableRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Table::class;
    }

    public function getByUrl(string $url) 
    {
        return $this->modelName::where('url',$url)->firstOrFail();
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }
}