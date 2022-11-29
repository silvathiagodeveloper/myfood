<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUpdateRoleRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleRepositoryInterface $repository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->repository = $roleRepository;
        $this->middleware("can:roles");
    }
    public function index()
    {
        $roles = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.roles.index', [
            'roles' => $roles
        ]);
    }

    public function search(Request $request)
    {
        $roles = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.roles.index', [
            'roles' => $roles,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.roles.create');
    }

    public function store(StoreUpdateRoleRequest $request) 
    {
        $this->repository->create($request->all());

        return redirect()->route('roles.index');
    }

    public function show($id) 
    {
        $role = $this->repository->getById($id);
        return view('admin.pages.roles.show',[
            'role' => $role
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);

        return redirect()->route('roles.index');
    }

    public function edit($id) 
    {
        $role = $this->repository->getById($id);

        return view('admin.pages.roles.edit',[
            'role' => $role
        ]);
    }

    public function update(StoreUpdateRoleRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('roles.index');
    }
}