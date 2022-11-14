<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CategoryWithDetailsException;
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

    public function destroy($url) 
    {
        try {
            $this->repository->delete($url);

            return redirect()->route('categories.index');
            
        } catch(CategoryWithDetailsException $err) {

            return redirect()->back()
                             ->withErrors([$err->getMessage()]);
        }
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
