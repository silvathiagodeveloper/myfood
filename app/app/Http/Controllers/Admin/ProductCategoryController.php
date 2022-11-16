<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\EmptyArrayException;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\ProductCategoryRepositoryInterface;
use App\Interfaces\Admin\ProductRepositoryInterface;
use App\Interfaces\Admin\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    private ProductRepositoryInterface $productRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private ProductCategoryRepositoryInterface $productCategoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository, 
        ProductCategoryRepositoryInterface $productCategoryRepository
    ){
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->middleware("can:products.show", ['only' => ['products', 'searchProducts']]);
        $this->middleware("can:categories.show", ['only' => ['categories', 'searchCategories', 'categoriesAvailable']]);
        $this->middleware("can:products.edit", ['only' => ['categoriesAttach', 'categoriesDetach']]);
    }

    public function categories(int $idProduct)
    {
        $product = $this->productRepository->getById($idProduct);
        $categories = $this->productCategoryRepository->getCategoriesPaginate($product, config('constants.max_paginate'));

        return view('admin.pages.products.categories.index',[
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function products(int $idCategory)
    {
        $category = $this->categoryRepository->getById($idCategory);
        $products = $this->productCategoryRepository->getProductsPaginate($category, config('constants.max_paginate'));

        return view('admin.pages.products.categories.products',[
            'category' => $category,
            'products' => $products
        ]);
    }

    public function searchCategories(Request $request, int $idProduct)
    {
        $product = $this->productRepository->getById($idProduct);
        $categories = $this->productCategoryRepository->getCategoriesPaginate($product, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.products.categories.index',[
            'product' => $product,
            'categories' => $categories,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function searchProducts(Request $request, int $idCategory)
    {
        $category = $this->categoryRepository->getById($idCategory);
        $products = $this->productCategoryRepository->getProductsPaginate($category, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.products.categories.products',[
            'category' => $category,
            'products' => $products,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function categoriesAvailable(Request $request, int $idProduct)
    {
        $product = $this->productRepository->getById($idProduct);
        $categories = $this->productCategoryRepository->getCategoriesAvailable($idProduct, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.products.categories.create', [
            'product' => $product,
            'categories' => $categories,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function categoriesAttach(Request $request, int $idProduct)
    {
        try {
            $this->productCategoryRepository->attachCategories($idProduct, $request->input('categories') ?? []);
            return redirect()->route('products.categories', $idProduct);
        } catch(EmptyArrayException $err) {
            return redirect()->back()
                             ->withErrors(['Pelo menos uma permissão deve ser selecionada!']);
        }
    }

    public function categoriesDetach(int $idProduct, int $idCategory)
    {
        $this->productCategoryRepository->detachCategories($idProduct, [$idCategory]);

        return redirect()->route('products.categories', $idProduct);
    }
}