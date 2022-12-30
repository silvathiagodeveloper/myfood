<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\Admin\TableRepository;

class DashboardController extends Controller
{
    public function index()
    {
        $productRep = new ProductRepository();
        $tableRep = new TableRepository();
        $orderRep = new OrderRepository();
        $products = $productRep->count();
        $tables = $tableRep->count();
        $orders = $orderRep->count();
        return view('admin.index',[
            'products' => $products,
            'tables' => $tables,
            'orders' => $orders
        ]);
    }
}