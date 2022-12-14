<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ProfileRepositoryInterface;
use App\Models\Admin\Profile;
use App\Repositories\BaseRepository;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Profile::class;
    }

    public function search(string $filter = null, int $qty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qty);
    }
}