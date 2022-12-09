<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;
use App\Models\Admin\Order;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function search(string $fiter = null, int $qty = 15);
    public function getByUuid(string $uuid);
    public function createProducts(Order $order, array $products);
}