<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\ACL\RolePermissionRepositoryInterface;
use App\Interfaces\Admin\PermissionRepositoryInterface;
use App\Interfaces\Admin\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    private RoleRepositoryInterface $roleRepository;
    private PermissionRepositoryInterface $permissionRepository;
    private RolePermissionRepositoryInterface $rolePermissionRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository, 
        PermissionRepositoryInterface $permissionRepository,
        RolePermissionRepositoryInterface $rolePermissionRepository
    ){
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->rolePermissionRepository = $rolePermissionRepository;
        $this->middleware("can:permissions");
        $this->middleware("can:roles");        
    }

    public function permissions(int $idRole)
    {
        $role = $this->roleRepository->getById($idRole);
        $permissions = $this->rolePermissionRepository->getPermissionsPaginate($role, config('constants.max_paginate'));

        return view('admin.pages.roles.permissions.index',[
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function roles(int $idPermission)
    {
        $permission = $this->permissionRepository->getById($idPermission);
        $roles = $this->rolePermissionRepository->getRolesPaginate($permission, config('constants.max_paginate'));

        return view('admin.pages.roles.permissions.roles',[
            'permission' => $permission,
            'roles' => $roles
        ]);
    }

    public function searchPermissions(Request $request, int $idRole)
    {
        $role = $this->roleRepository->getById($idRole);
        $permissions = $this->rolePermissionRepository->getPermissionsPaginate($role, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.roles.permissions.index',[
            'role' => $role,
            'permissions' => $permissions,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function searchRoles(Request $request, int $idPermission)
    {
        $permission = $this->permissionRepository->getById($idPermission);
        $roles = $this->rolePermissionRepository->getRolesPaginate($permission, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.roles.permissions.roles',[
            'permission' => $permission,
            'roles' => $roles,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function permissionsAvailable(Request $request, int $idRole)
    {
        $role = $this->roleRepository->getById($idRole);
        $permissions = $this->rolePermissionRepository->getPermissionsAvailable($idRole, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.roles.permissions.create', [
            'role' => $role,
            'permissions' => $permissions,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function permissionsAttach(Request $request, int $idRole)
    {
        try {
            $this->rolePermissionRepository->attachPermissions($idRole, $request->input('permissions') ?? []);
            return redirect()->route('roles.permissions', $idRole);
        } catch(EmptyArrayException $err) {
            return redirect()->back()
                             ->withErrors(['Pelo menos uma permissão deve ser selecionada!']);
        }
    }

    public function permissionsDetach(int $idRole, int $idPermission)
    {
        $this->rolePermissionRepository->detachPermissions($idRole, [$idPermission]);

        return redirect()->route('roles.permissions', $idRole);
    }
}