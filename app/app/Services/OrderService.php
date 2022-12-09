<?php

namespace App\Services;

use App\Interfaces\Admin\OrderRepositoryInterface;
use App\Interfaces\Admin\ProductRepositoryInterface;
use App\Interfaces\Admin\TableRepositoryInterface;
use App\Interfaces\Admin\TenantRepositoryInterface;
use App\Repositories\Admin\ProductRepository;

class OrderService
{
    private OrderRepositoryInterface $orderRepository;
    private TenantRepositoryInterface $tenantRepository;
    private TableRepositoryInterface $tableRepository;
    private ProductRepositoryInterface $productRepository;

    public function __construct(OrderRepositoryInterface $OrderRepository, 
                                TenantRepositoryInterface $tenantRepository, 
                                TableRepositoryInterface $tableRepository,
                                ProductRepositoryInterface $productRepository)
    {
        $this->orderRepository = $OrderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
        $this->productRepository = $productRepository;
    }
    public function getAllPaginate($perPage = null)
    {
        $perPage = (int) ($perPage ?? config('constants.max_paginate'));
        return $this->orderRepository->getAllPaginate($perPage);
    }

    public function getByClient($perPage = null)
    {
        $idClient = $this->getClientId();
        $perPage = (int) ($perPage ?? config('constants.max_paginate'));
        return $this->orderRepository->getAllFilteredPaginate(['client_id' => $idClient], $perPage);
    }

    public function getByUuid(string $uuid) 
    {
        return $this->orderRepository->getByUuid($uuid);
    }

    public function create(array $order) 
    {
        $products = $this->getProducts($order['products']);
        $order = $this->orderRepository->create(
            [
                'total'     => $this->getTotalOrder($products), 
                'status'    => 'open', 
                'tenant_id' => $this->getTenantId($order['token_company']), 
                'client_id' => $this->getClientId(),
                'table_id'  => $this->getTableId($order['table'] ?? null),
                'description'  => $order['description'] ?? null
            ]
        );
        $this->orderRepository->createProducts($order, $products);
        return $order;
    }

    private function getTotalOrder(array $products): float
    {
        $total = 0;
        foreach($products as $product) {
            $total += $product['qty'] * $product['price'];
        }
        return (float) $total;
    }

    private function getStatus(): string
    {
        return 'open';
    }

    private function getTenantId(string $uuid): int|null
    {
        return $this->tenantRepository->getByUuid($uuid)->id;
    }

    private function getTableId(string|null $uuid = null): int|null
    {
        if (!empty($uuid)) {
            return $this->tableRepository->getByUuid($uuid)->id;
        }
        return null;
    }

    private function getClientId(): int|null
    {
        return auth()->check() ? auth()->user()->id : null;
    }

    private function getProducts(array $products): array
    {
        $temp = $products;
        $products = [];
        foreach($temp as $product) {
            $products[$product['id']] = $product;
        }
        $arrProducts = $this->productRepository->getAllFilteredByUuid(array_keys($products));
        foreach($arrProducts as $product) {
            $products[$product->uuid]['id'] = $product->id;
            $products[$product->uuid]['price'] = $product->price;
        }
        return $products;
    }
}