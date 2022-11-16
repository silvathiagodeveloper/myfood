<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUpdatePermissionRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private PermissionRepositoryInterface $repository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->repository = $permissionRepository;
        $this->middleware("can:permissions");
    }
    public function index()
    {
        $permissions = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    public function search(Request $request)
    {
        $permissions = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.permissions.index', [
            'permissions' => $permissions,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.permissions.create');
    }

    public function store(StoreUpdatePermissionRequest $request) 
    {
        $this->repository->create($request->all());

        return redirect()->route('permissions.index');
    }

    public function show($id) 
    {
        $permission = $this->repository->getById($id);
        return view('admin.pages.permissions.show',[
            'permission' => $permission
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);

        return redirect()->route('permissions.index');
    }

    public function edit($id) 
    {
        $permission = $this->repository->getById($id);

        return view('admin.pages.permissions.edit',[
            'permission' => $permission
        ]);
    }

    public function update(StoreUpdatePermissionRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('permissions.index');
    }
}