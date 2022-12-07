<?php

namespace App\Repositories;

use App\Interfaces\UrlUuidRepositoryInterface;

abstract class UrlUuidRepository extends BaseRepository implements UrlUuidRepositoryInterface
{
    public function getByUrl(string $url) 
    {
        return $this->modelName::where('url',$url)->firstOrFail();
    }

    public function getByUuid(string $uuid) 
    {
        return $this->modelName::where('uuid',$uuid)->firstOrFail();
    }
}