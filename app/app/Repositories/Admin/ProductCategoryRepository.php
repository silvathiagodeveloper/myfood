<?php

namespace App\Repositories\Admin;

use App\Exceptions\EmptyArrayException;
use App\Interfaces\Admin\ProductCategoryRepositoryInterface;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Repositories\BaseRepository;

class ProductCategoryRepository extends BaseRepository implements ProductCategoryRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Product::class;
    }
    public function getCategories(Product $product) 
    {
        return $product->categories();
    }

    public function getCategoriesPaginate(Product $product, int $qty = 15, string $filter = null) 
    {
        $return = $product->categories();
        if(isset($filter)) {
            $return = $return->where('categories.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qty);
    }

    public function attachCategories(int $id, array $categories)
    {
        if(count($categories) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $product = $this->getById($id);
        $product->categories()->attach($categories);
        return $product;
    }

    public function detachCategories(int $id, array $categories)
    {
        if(count($categories) == 0) {
            throw new EmptyArrayException('Array vazio');
        }
        $product = $this->getById($id);
        $product->categories()->detach($categories);
        return $product;
    }

    public function detachAllCategories(int $id)
    {
        $product = $this->getById($id);
        $product->categories()->detach();
        return $product;
    }

    public function getCategoriesAvailable(int $productId, int $qty = 15, string $filter = null)
    {
        $return = Category::latest();
        if(isset($filter)) {
            $return = $return->filter($filter);
        }
        $return = $return->whereNotIn('id', function($q) use ($productId) {
                                    $q->select('product_category.category_id') 
                                        ->from('product_category')
                                        ->where('product_category.product_id', $productId);
                                });

        return $return->paginate($qty);
    }

    public function getProductsPaginate(Category $category, int $qty = 15, string $filter = null) 
    {
        $return = $category->products();
        if(isset($filter)) {
            $return = $return->where('products.name', 'LIKE', "%{$filter}%");
        }
        return $return->paginate($qty);
    }
}