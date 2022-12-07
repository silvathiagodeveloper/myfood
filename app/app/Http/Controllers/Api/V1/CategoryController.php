<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\CategoryResourceCollection;
use App\Interfaces\Admin\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }
    public function index(Request $request)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $categories = $this->repository->getAllPaginate($perPage);

        return new CategoryResourceCollection($categories);
    }

    public function show($url) 
    {
        $category = $this->repository->getByUrl($url);
        return new CategoryResource($category);
    }
}
