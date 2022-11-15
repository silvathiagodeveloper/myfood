<?php

namespace App\Repositories\Admin;

use App\Exceptions\ProductWithDetailsException;
use App\Interfaces\Admin\ProductRepositoryInterface;
use App\Models\Admin\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Product::class;
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

    public function delete(int $id) 
    {
        $product = $this->modelName::findOrFail($id);
        $prodCategRep = new ProductCategoryRepository();
        $prodCategRep->detachAllCategories($id);
        return $product->delete();
    }
}