<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Comprador']);


        Permission::create(['name' => 'admin.categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'products.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'products.create'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'pedidos.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'pedidos.update'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.users'])->syncRoles([$role1]);


        
    }
}
