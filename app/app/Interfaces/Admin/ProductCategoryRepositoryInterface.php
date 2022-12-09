<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Product;
use App\Models\Admin\Category;

interface ProductCategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getCategories(Product $product);

    public function getCategoriesPaginate(Product $product, int $qty = 15, string $filter = null);

    public function attachCategories(int $id, array $categorys);

    public function detachCategories(int $id, array $categorys);

    public function detachAllCategories(int $id);

    public function getCategoriesAvailable(int $ProductId, int $qty = 15, string $filter = null);

    public function getProductsPaginate(Category $category, int $qty = 15, string $filter = null);
}