<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TenantResource;
use App\Http\Resources\V1\TenantResourceCollection;
use App\Interfaces\Admin\TenantRepositoryInterface;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    private TenantRepositoryInterface $repository;

    public function __construct(TenantRepositoryInterface $TenantRepository)
    {
        $this->repository = $TenantRepository;
    }
    public function index(Request $request)
    {
        $perPage = (int) ($request->per_page ?? config('constants.max_paginate'));
        $tenants = $this->repository->getAllPaginate($perPage);

        return new TenantResourceCollection($tenants);
    }

    public function show($uuid) 
    {
        $tenant = $this->repository->getByUuid($uuid);
        return new TenantResource($tenant);
    }
}