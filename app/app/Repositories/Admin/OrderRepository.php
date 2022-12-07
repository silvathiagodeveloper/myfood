<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\OrderRepositoryInterface;
use App\Models\Admin\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Order::class;
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->where('status', "%{$filter}%")
                    ->paginate($qtty);
    }

    public function getByUuid(string $uuid) 
    {
        return $this->modelName::where('uuid',"{$uuid}")
                                ->firstOrFail();
    }
}