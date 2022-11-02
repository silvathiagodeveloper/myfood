<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Http\Requests\StoreUpdateProfileRequest;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Interfaces\Admin\ProfileRepositoryInterface;
use Illuminate\Http\Request;

class ProfilePermissionController extends Controller
{
    private ProfileRepositoryInterface $profileRepository;
    private PermissionRepositoryInterface $permissionRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function permissions(int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $permissions = $this->profileRepository->getPermissionsPaginate($profile, config('constants.max_paginate'));

        return view('admin.pages.profiles.permissions.index',[
            'profile' => $profile,
            'permissions' => $permissions
        ]);
    }

    public function search(Request $request, int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $permissions = $this->profileRepository->getPermissionsPaginate($profile, config('constants.max_paginate'));

        return view('admin.pages.profiles.permissions.index',[
            'profile' => $profile,
            'permissions' => $permissions
        ]);
    }

    public function permissionsAvailable(int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $permissions = $this->permissionRepository->getByProfileId($idProfile, config('constants.max_paginate'));

        return view('admin.pages.profiles.permissions.create', [
                'profile' => $profile,
                'permissions' => $permissions
        ]);
    }

    public function permissionsAttach(Request $request, int $idProfile)
    {
        try {
            $this->profileRepository->attachPermissions($idProfile, $request->input('permissions') ?? []);
            return redirect()->route('profiles.permissions.index', $idProfile);
        } catch(EmptyArrayException $err) {
            return redirect()->back()
                             ->withErrors(['Pelo menos uma permissão deve ser selecionada!']);
        }
    }

    public function permissionsDetach(Request $request, int $idProfile)
    {
        //$this->profileRepository->detachPermissions($idProfile, $request->input('permission_id') ?? []);

        return redirect()->route('profiles.permissions.index', $idProfile);
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