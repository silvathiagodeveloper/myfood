<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TableResource;
use App\Http\Resources\V1\TableResourceCollection;
use App\Interfaces\Admin\TableRepositoryInterface;
use Illuminate\Http\Request;

class TableController extends Controller
{
    private TableRepositoryInterface $repository;

    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->repository = $tableRepository;
    }
    public function index(Request $request)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $tables = $this->repository->getAllPaginate($perPage);

        return new TableResourceCollection($tables);
    }

    public function show($url) 
    {
        $table = $this->repository->getByUrl($url);
        return new TableResource($table);
    }
}
