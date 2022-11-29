<?php

namespace App\Traits;

trait UserACLTrait
{
    public function permissions() : array
    {
        $permissionsPlan = $this->permissionsPlan();
        $permissionsRole = $this->permissionsRole();
        return array_intersect_key($permissionsRole, $permissionsPlan);
    }

    public function permissionsPlan() : array
    {
        $profiles = $this->tenant()
                    ->first()
                    ->plan()
                    ->first()
                    ->profiles;
        $permissions = [];
        foreach($profiles as $profile) {
            foreach($profile->permissions as $permission) {
                $permissions[$permission->name] = true;
            }
        }
        return $permissions;
    }

    public function permissionsRole() : array
    {
        $roles = $this->roles;
        $permissions = [];
        foreach($roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[$permission->name] = true;
            }
        }
        return $permissions;
    }

    public function hasPermission(string $permissionName) : bool
    {
        $permissions = $this->permissions();
        return isset($permissions[$permissionName]);
    }

    public function isAdmin() : bool
    {
        return in_array($this->email,config('acl.admins'));
    }
}