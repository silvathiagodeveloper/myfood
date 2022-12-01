<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUpdateCategoryRequest;
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
        /*$this->middleware("can:categories.show", ['only' => ['index','show','search']]);
        $this->middleware("can:categories.create", ['only' => ['create','store']]);
        $this->middleware("can:categories.edit", ['only' => ['edit','update']]);
        $this->middleware("can:categories.destroy", ['only' => ['destroy']]);*/
    }
    public function index(Request $request)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $categories = $this->repository->getAllPaginate($perPage);

        return new CategoryResourceCollection($categories);
    }

    public function show($uuid) 
    {
        $category = $this->repository->getByUrl($uuid);
        return new CategoryResource($category);
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(StoreUpdateCategoryRequest $request) 
    {
        $model = $this->repository->create($request->all());

        return redirect()->route('categories.index');
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);
        return redirect()->route('categories.index');          
    }

    public function edit($url) 
    {
        $category = $this->repository->getByUrl($url);

        return view('admin.pages.categories.edit',[
            'category' => $category
        ]);
    }

    public function update(StoreUpdateCategoryRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('categories.index');
    }
}
