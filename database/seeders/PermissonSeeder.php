<?php

namespace Database\Seeders;

use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;

class PermissonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name'     => 'edit-item',
            'guard_name'    => 'web',
        ]);
        Permission::create([
            'name'     => 'changeStateItem',
            'guard_name'    => 'web',
        ]);
        Permission::create([
            'name'     => 'edit-import',
            'guard_name'    => 'web',
        ]);
        Permission::create([
            'name'     => 'edit-export',
            'guard_name'    => 'web',
        ]);
        Permission::create([
            'name'     => 'edit-customer',
            'guard_name'    => 'web',
        ]);
        Permission::create([
            'name'     => 'edit-supplier',
            'guard_name'    => 'web',
        ]);
        $adminRole = Role::create([
            'name'     => 'admin',
            'guard_name'    => 'web',

        ]);
        $adminRole->givePermissionTo('changeStateItem');
        $adminRole->givePermissionTo('edit-item');
        $adminRole->givePermissionTo('edit-import');
        $adminRole->givePermissionTo('edit-export');
        $adminRole->givePermissionTo('edit-customer');
        $adminRole->givePermissionTo('edit-supplier');
    }
}