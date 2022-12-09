<?php

namespace App\Interfaces\Admin;

use App\Interfaces\UrlUuidRepositoryInterface;

interface ProductRepositoryInterface extends UrlUuidRepositoryInterface
{
    public function getAllFilteredByUuid(array $filter = null);
    public function search(string $fiter = null, int $qty = 15);
}