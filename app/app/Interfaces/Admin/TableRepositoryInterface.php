<?php

namespace App\Interfaces\Admin;

use App\Interfaces\UrlUuidRepositoryInterface;

interface TableRepositoryInterface extends UrlUuidRepositoryInterface
{
    public function search(string $fiter = null, int $qtty = 15);
}