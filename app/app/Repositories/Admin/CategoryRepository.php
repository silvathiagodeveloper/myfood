<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\CategoryRepositoryInterface;
use App\Models\Admin\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Category::class;
    }

    public function getByUrl(string $url) 
    {
        return $this->modelName::where('url',$url)->firstOrFail();
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }
}