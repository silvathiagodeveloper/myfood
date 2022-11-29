<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUpdateTenantRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\TenantRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    private TenantRepositoryInterface $repository;

    public function __construct(TenantRepositoryInterface $TenantRepository)
    {
        $this->repository = $TenantRepository;
        $this->middleware("can:tenants");
    }
    public function index()
    {
        $tenants = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.tenants.index', [
            'tenants' => $tenants
        ]);
    }

    public function search(Request $request)
    {
        $tenants = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.tenants.index', [
            'tenants' => $tenants,
            'filters' => $filters
        ]);
    }

    public function show($id) 
    {
        $tenant = $this->repository->getById($id);
        return view('admin.pages.tenants.show',[
            'tenant' => $tenant
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);

        return redirect()->route('tenants.index');
    }

    public function edit($id) 
    {
        $tenant = $this->repository->getById($id);

        return view('admin.pages.tenants.edit',[
            'tenant' => $tenant
        ]);
    }

    public function update(StoreUpdateTenantRequest $request, int $id) 
    {
        if($request->hasFile('logo') && $request->logo->isValid()) {
            $tenant = $this->repository->getById($id);
            if(Storage::exists($tenant->logo)) {
                Storage::delete($tenant->logo);
            }
            $data['logo'] = $request->logo->store("tenants/{$tenant->uuid}/logos");
        }

        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('tenants.index');
    }
}