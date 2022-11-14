<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\ACL\ProfilePermissionRepositoryInterface;
use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Interfaces\Admin\ProfileRepositoryInterface;
use Illuminate\Http\Request;

class ProfilePermissionController extends Controller
{
    private ProfileRepositoryInterface $profileRepository;
    private PermissionRepositoryInterface $permissionRepository;
    private ProfilePermissionRepositoryInterface $profilePermissionRepository;

    public function __construct(
        ProfileRepositoryInterface $profileRepository, 
        PermissionRepositoryInterface $permissionRepository,
        ProfilePermissionRepositoryInterface $profilePermissionRepository
    ){
        $this->profileRepository = $profileRepository;
        $this->permissionRepository = $permissionRepository;
        $this->profilePermissionRepository = $profilePermissionRepository;
    }

    public function permissions(int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $permissions = $this->profilePermissionRepository->getPermissionsPaginate($profile, config('constants.max_paginate'));

        return view('admin.pages.profiles.permissions.index',[
            'profile' => $profile,
            'permissions' => $permissions
        ]);
    }

    public function profiles(int $idPermission)
    {
        $permission = $this->permissionRepository->getById($idPermission);
        $profiles = $this->profilePermissionRepository->getProfilesPaginate($permission, config('constants.max_paginate'));

        return view('admin.pages.profiles.permissions.profiles',[
            'permission' => $permission,
            'profiles' => $profiles
        ]);
    }

    public function searchPermissions(Request $request, int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $permissions = $this->profilePermissionRepository->getPermissionsPaginate($profile, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.profiles.permissions.index',[
            'profile' => $profile,
            'permissions' => $permissions,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function searchProfiles(Request $request, int $idPermission)
    {
        $permission = $this->permissionRepository->getById($idPermission);
        $profiles = $this->profilePermissionRepository->getProfilesPaginate($permission, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.profiles.permissions.profiles',[
            'permission' => $permission,
            'profiles' => $profiles,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function permissionsAvailable(Request $request, int $idProfile)
    {
        $profile = $this->profileRepository->getById($idProfile);
        $permissions = $this->profilePermissionRepository->getPermissionsAvailable($idProfile, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.profiles.permissions.create', [
            'profile' => $profile,
            'permissions' => $permissions,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function permissionsAttach(Request $request, int $idProfile)
    {
        try {
            $this->profilePermissionRepository->attachPermissions($idProfile, $request->input('permissions') ?? []);
            return redirect()->route('profiles.permissions', $idProfile);
        } catch(EmptyArrayException $err) {
            return redirect()->back()
                             ->withErrors(['Pelo menos uma permissão deve ser selecionada!']);
        }
    }

    public function permissionsDetach(int $idProfile, int $idPermission)
    {
        $this->profilePermissionRepository->detachPermissions($idProfile, [$idPermission]);

        return redirect()->route('profiles.permissions', $idProfile);
    }
}