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
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            PermissonSeeder::class,
            ItemsSeeder::class,
            ExportSeeder::class,
            ImportSeeder::class

        ]);



        $admin->assignRole('admin');
    }
}