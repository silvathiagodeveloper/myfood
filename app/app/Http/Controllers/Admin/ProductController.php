<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUpdateProductRequest;
use App\Interfaces\Admin\ProductRepositoryInterface;
use App\Services\Tenant\TenantManager;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    public function index()
    {
        $products = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.products.index', [
            'products' => $products
        ]);
    }

    public function search(Request $request)
    {
        $products = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.products.index', [
            'products' => $products,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.products.create');
    }

    public function store(StoreUpdateProductRequest $request) 
    {
        $data = $request->except('image');

        $tenant = app(TenantManager::class)->getTenant();

        if($request->hasFile('image') && $request->image->isValid()) {
            $data['image'] = $request->image->store("tenants/{$tenant->uuid}/products");
        }

        $model = $this->repository->create($data);

        return redirect()->route('products.index');
    }

    public function show($url) 
    {
        $product = $this->repository->getByUrl($url);
        return view('admin.pages.products.show',[
            'product' => $product
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);

        return redirect()->route('products.index');
    }

    public function edit($url) 
    {
        $product = $this->repository->getByUrl($url);

        return view('admin.pages.products.edit',[
            'product' => $product
        ]);
    }

    public function update(StoreUpdateProductRequest $request, int $id) 
    {
        $data = $request->except(['_token','_method', 'image']);

        $tenant = app(TenantManager::class)->getTenant();

        if($request->hasFile('image') && $request->image->isValid()) {
            $data['image'] = $request->image->store("tenants/{$tenant->uuid}/products");
        }

        $this->repository->update($id, $data);

        return redirect()->route('products.index');
    }
}
