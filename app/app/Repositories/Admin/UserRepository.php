<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = User::class;
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }
}