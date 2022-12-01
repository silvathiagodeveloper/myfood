<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Exceptions\EmptyArrayException;
use App\Http\Controllers\Controller;
use App\Interfaces\Admin\ACL\UserRoleRepositoryInterface;
use App\Interfaces\Admin\UserRepositoryInterface;
use App\Interfaces\Admin\RoleRepositoryInterface;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private RoleRepositoryInterface $roleRepository;
    private UserRoleRepositoryInterface $userRoleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository, 
        UserRoleRepositoryInterface $userRoleRepository
    ){
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->middleware("can:users");
        $this->middleware("can:roles");        
    }

    public function roles(int $idUser)
    {
        $user = $this->userRepository->getById($idUser);
        $roles = $this->userRoleRepository->getRolesPaginate($user, config('constants.max_paginate'));

        return view('admin.pages.users.roles.index',[
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function users(int $idRole)
    {
        $role = $this->roleRepository->getById($idRole);
        $users = $this->userRoleRepository->getUsersPaginate($role, config('constants.max_paginate'));

        return view('admin.pages.users.roles.users',[
            'role' => $role,
            'users' => $users
        ]);
    }

    public function searchRoles(Request $request, int $idUser)
    {
        $user = $this->userRepository->getById($idUser);
        $roles = $this->userRoleRepository->getRolesPaginate($user, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.users.roles.index',[
            'user' => $user,
            'roles' => $roles,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function searchUsers(Request $request, int $idRole)
    {
        $role = $this->roleRepository->getById($idRole);
        $users = $this->userRoleRepository->getUsersPaginate($role, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.users.roles.users',[
            'role' => $role,
            'users' => $users,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function rolesAvailable(Request $request, int $idUser)
    {
        $user = $this->userRepository->getById($idUser);
        $roles = $this->userRoleRepository->getRolesAvailable($idUser, config('constants.max_paginate'), $request->filter ?? null);

        return view('admin.pages.users.roles.create', [
            'user' => $user,
            'roles' => $roles,
            'filters' => ['filter' => $request->filter ?? null]
        ]);
    }

    public function rolesAttach(Request $request, int $idUser)
    {
        try {
            $this->userRoleRepository->attachRoles($idUser, $request->input('roles') ?? []);
            return redirect()->route('users.roles', $idUser);
        } catch(EmptyArrayException $err) {
            return redirect()->back()
                             ->withErrors(['Pelo menos uma permissão deve ser selecionada!']);
        }
    }

    public function rolesDetach(int $idUser, int $idRole)
    {
        $this->userRoleRepository->detachRoles($idUser, [$idRole]);

        return redirect()->route('users.roles', $idUser);
    }
}