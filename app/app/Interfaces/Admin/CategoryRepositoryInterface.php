<?php

namespace App\Interfaces\Admin;

use App\Interfaces\BaseRepositoryInterface;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getByUrl(string $url);

    public function search(string $fiter = null, int $qtty = 15);
}