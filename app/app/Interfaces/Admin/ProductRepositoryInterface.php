<?php

namespace App\Interfaces\Admin;

use App\Interfaces\UrlUuidRepositoryInterface;

interface ProductRepositoryInterface extends UrlUuidRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);
}