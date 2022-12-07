<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\ProductResourceCollection;
use App\Interfaces\Admin\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }
    public function index(Request $request)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $products = $this->repository->getAllPaginate($perPage);

        return new ProductResourceCollection($products);
    }

    public function show($url) 
    {
        $product = $this->repository->getByUrl($url);
        return new ProductResource($product);
    }
}
