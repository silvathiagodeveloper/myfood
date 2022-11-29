<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUpdateCategoryRequest;
use App\Interfaces\Admin\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->repository = $categoryRepository;
        $this->middleware("can:categories.show", ['only' => ['index','show','search']]);
        $this->middleware("can:categories.create", ['only' => ['create','store']]);
        $this->middleware("can:categories.edit", ['only' => ['edit','update']]);
        $this->middleware("can:categories.destroy", ['only' => ['destroy']]);
    }
    public function index()
    {
        $categories = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.categories.index', [
            'categories' => $categories
        ]);
    }

    public function search(Request $request)
    {
        $categories = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.categories.index', [
            'categories' => $categories,
            'filters' => $filters
        ]);
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

    public function show($url) 
    {
        $category = $this->repository->getByUrl($url);
        return view('admin.pages.categories.show',[
            'category' => $category
        ]);
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
