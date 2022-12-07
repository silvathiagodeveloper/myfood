<?php

namespace App\Interfaces;

interface UrlUuidRepositoryInterface extends BaseRepositoryInterface
{
    public function getByUrl(string $url);
    public function getByUuid(string $uuid);
}