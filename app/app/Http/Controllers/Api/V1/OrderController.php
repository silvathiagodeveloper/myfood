<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\OrderCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Resources\v1\OrderResource;
use App\Http\Resources\V1\OrderResourceCollection;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index(Request $request)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $orders = $this->orderService->getAllPaginate($perPage);

        return new OrderResourceCollection($orders);
    }

    public function myOrders(Request $request)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $orders = $this->orderService->getByClient($perPage);

        return new OrderResourceCollection($orders);
    }

    public function show($uuid) 
    {
        $order = $this->orderService->getByUuid($uuid);
        return new OrderResource($order);
    }

    public function store(StoreOrderRequest $request) 
    {
        $order = $this->orderService->create($request->all());
        broadcast(new OrderCreatedEvent($order));
        return new OrderResource($order);
    }
}