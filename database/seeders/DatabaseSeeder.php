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
            'email'    => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);
        User::factory(10)->create();
        $supplier = Supplier::create([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'phone' => Str::random(10),
        ]);
        $supplier1 = Supplier::create([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'phone' => Str::random(10),
        ]);
        $customer = Customer::create([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'phone' => Str::random(10),
        ]);
        $customer1 = Customer::create([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'phone' => Str::random(10),
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
            'name'     => 'changeState',
            'guard_name'    => 'web',
        ]);
        $adminRole->givePermissionTo('changeState');
        $adminRole->givePermissionTo('edit-item');
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