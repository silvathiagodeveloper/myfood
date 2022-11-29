<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = ['users', 'categories', 'products', 'tables'];
        $permissions = [];
        foreach($modules as $module) {
            array_push($permissions, [
                'name'    => "{$module}.show",
                'description' => "Listar ou exibir {$module}"
            ],
            [
                'name'    => "{$module}.create",
                'description' => "Criar {$module}"
            ],
            [
                'name'    => "{$module}.edit",
                'description' => "Editar {$module}"
            ],
            [
                'name'    => "{$module}.destroy",
                'description' => "Excluir {$module}"
            ]);
        }
        foreach($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
