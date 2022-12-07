<?php

namespace App\Services;

use App\Interfaces\Admin\OrderRepositoryInterface;
use App\Interfaces\Admin\TableRepositoryInterface;
use App\Interfaces\Admin\TenantRepositoryInterface;

class OrderService
{
    private OrderRepositoryInterface $orderRepository;
    private TenantRepositoryInterface $tenantRepository;
    private TableRepositoryInterface $tableRepository;

    public function __construct(OrderRepositoryInterface $OrderRepository, 
                                TenantRepositoryInterface $tenantRepository, 
                                TableRepositoryInterface $tableRepository)
    {
        $this->orderRepository = $OrderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
    }
    public function getAllPaginate($perPage = null)
    {
        $perPage = (int) ($perPage ?? config('constants.max_paginate'));
        return $this->orderRepository->getAllPaginate($perPage);
    }

    public function getByUuid(string $uuid) 
    {
        return $this->orderRepository->getByUuid($uuid);
    }

    public function create(array $order) 
    {
        $order = $this->orderRepository->create(
            [
                'total'     => $this->getTotalOrder($order['products']), 
                'status'    => 'open', 
                'tenant_id' => $this->getTenantId($order['token_company']), 
                'client_id' => $this->getClientId(),
                'table_id'  => $this->getTableId($order['table'] ?? null),
                'description'  => $order['description'] ?? null
            ]
        );
        return $order;
    }

    private function getTotalOrder(array $products): float
    {
        $total = 0;
        foreach($products as $product) {
            $total += $product['qtty'] * $product['price'];
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
}