<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Export;
use App\Models\Import;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name'     => 'Demo Admin',
            'email'    => 'admin@rikaz.com',
            'password' => bcrypt('12345678'),
        ]);
        $users = User::factory(10)->create();
        $supplier = Supplier::create([
            'user_id' => $users[0]->id

        ]);
        $supplier1 = Supplier::create([
            'user_id' => $users[1]->id,
        ]);
        $customer = Customer::create([
            'user_id' => $users[0]->id
        ]);
        $customer1 = Customer::create([
            'user_id' => $users[1]->id
        ]);
        $adminRole = Role::create([
            'name'     => 'admin',
            'guard_name'    => 'web',

        ]);
        Role::create([
            'name'     => 'edit-item',
            'guard_name'    => 'web',

        ]);
        $editPer = Permission::create([
            'name'     => 'edit-item',
            'guard_name'    => 'web',
        ]);
        $changePer = Permission::create([
            'name'     => 'changeStateItem',
            'guard_name'    => 'web',
        ]);
        $changePer = Permission::create([
            'name'     => 'edit-import',
            'guard_name'    => 'web',
        ]);
        $changePer = Permission::create([
            'name'     => 'edit-export',
            'guard_name'    => 'web',
        ]);
        $changePer = Permission::create([
            'name'     => 'edit-customer',
            'guard_name'    => 'web',
        ]);
        $changePer = Permission::create([
            'name'     => 'edit-supplier',
            'guard_name'    => 'web',
        ]);
        $adminRole->givePermissionTo('changeStateItem');
        $adminRole->givePermissionTo('edit-item');
        $adminRole->givePermissionTo('edit-import');
        $adminRole->givePermissionTo('edit-export');
        $adminRole->givePermissionTo('edit-customer');
        $adminRole->givePermissionTo('edit-supplier');

        $admin->assignRole('admin');
        $category = Category::factory(2)->create();
        $items = Item::factory(5)->create(['category_id' => $category[0]]);
        $items2 = Item::factory(5)->create(['category_id' => $category[1]]);

        for ($i = 0; $i < 5; $i++) {

            Import::factory(4)->create([
                'item_id' => $items[$i],
                'supplier_id' => $supplier->id
            ]);
        }
        for ($i = 0; $i < 5; $i++) {

            Import::factory(4)->create([
                'item_id' => $items2[$i],
                'supplier_id' => $supplier1->id
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            Export::factory(4)->create([
                'item_id' => $items[$i],
                'customer_id' => $customer->id
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Export::factory(4)->create([
                'item_id' => $items2[$i],
                'customer_id' => $customer1->id
            ]);
        }
    }
}
