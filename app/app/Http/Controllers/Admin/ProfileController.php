<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUpdateProfileRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\ProfileRepositoryInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private ProfileRepositoryInterface $repository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->repository = $profileRepository;
        $this->middleware("can:profiles");
    }
    public function index()
    {
        $profiles = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.profiles.index', [
            'profiles' => $profiles
        ]);
    }

    public function search(Request $request)
    {
        $profiles = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.profiles.index', [
            'profiles' => $profiles,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.profiles.create');
    }

    public function store(StoreUpdateProfileRequest $request) 
    {
        $this->repository->create($request->all());

        return redirect()->route('profiles.index');
    }

    public function show($id) 
    {
        $profile = $this->repository->getById($id);
        return view('admin.pages.profiles.show',[
            'profile' => $profile
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);

        return redirect()->route('profiles.index');
    }

    public function edit($id) 
    {
        $profile = $this->repository->getById($id);

        return view('admin.pages.profiles.edit',[
            'profile' => $profile
        ]);
    }

    public function update(StoreUpdateProfileRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('profiles.index');
    }
}