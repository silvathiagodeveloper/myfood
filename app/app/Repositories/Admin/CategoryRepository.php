<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\CategoryRepositoryInterface;
use App\Models\Admin\Category;
use App\Repositories\UrlUuidRepository;

class CategoryRepository extends UrlUuidRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Category::class;
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }
}