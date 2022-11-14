<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUpdateUserRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }
    public function index()
    {
        $users = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.users.index', [
            'users' => $users
        ]);
    }

    public function search(Request $request)
    {
        $users = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.users.index', [
            'users' => $users,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(StoreUpdateUserRequest $request) 
    {
        $request->request->add([
            'tenant_id' => auth()->user()->tenant_id
        ]);
        $this->repository->create($request->all());

        return redirect()->route('users.index');
    }

    public function show($id) 
    {
        $user = $this->repository->getById($id);
        return view('admin.pages.users.show',[
            'user' => $user
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);

        return redirect()->route('users.index');
    }

    public function edit($id) 
    {
        $user = $this->repository->getById($id);

        return view('admin.pages.users.edit',[
            'user' => $user
        ]);
    }

    public function update(StoreUpdateUserRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('users.index');
    }
}