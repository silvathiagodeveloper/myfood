<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResourceCollection;
use App\Interfaces\Admin\ProductCategoryRepositoryInterface;
use App\Interfaces\Admin\ProductRepositoryInterface;
use App\Interfaces\Admin\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;
    private ProductCategoryRepositoryInterface $productCategoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository, 
        ProductCategoryRepositoryInterface $productCategoryRepository
    ){
        $this->categoryRepository = $categoryRepository;
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function products(Request $request, string $urlCategory)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $category = $this->categoryRepository->getByUrl($urlCategory);
        $products = $this->productCategoryRepository->getProductsPaginate($category, $perPage);

        return new ProductResourceCollection($products);
    }
}