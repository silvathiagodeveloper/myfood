<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUpdateTenantRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\TenantRepositoryInterface;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    private TenantRepositoryInterface $repository;

    public function __construct(TenantRepositoryInterface $TenantRepository)
    {
        $this->repository = $TenantRepository;
    }
    public function index()
    {
        $Tenants = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.Tenants.index', [
            'Tenants' => $Tenants
        ]);
    }

    public function search(Request $request)
    {
        $Tenants = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.Tenants.index', [
            'Tenants' => $Tenants,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.Tenants.create');
    }

    public function store(StoreUpdateTenantRequest $request) 
    {
        $this->repository->create($request->all());

        return redirect()->route('Tenants.index');
    }

    public function show($id) 
    {
        $Tenant = $this->repository->getById($id);
        return view('admin.pages.Tenants.show',[
            'Tenant' => $Tenant
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);

        return redirect()->route('Tenants.index');
    }

    public function edit($id) 
    {
        $Tenant = $this->repository->getById($id);

        return view('admin.pages.Tenants.edit',[
            'Tenant' => $Tenant
        ]);
    }

    public function update(StoreUpdateTenantRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('Tenants.index');
    }
}