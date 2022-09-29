<?php

namespace Database\Seeders;

use App\Models\User;
use Backpack\PermissionManager\app\Models\Permission;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([

        //     UserSeeder::class,

        // ]);
        // User::truncate();

        // // Create admin
        // User::create([
        //     'name'     => 'Demo Admin',
        //     'email'    => 'admisna@example.com',
        //     'password' => bcrypt('admin'),
        // ]);

        // User::factory(10)->create();
        $admin = User::create([
            'name'     => 'Demo Admin',
            'email'    => 'admisna@example.com',
            'password' => bcrypt('admin'),
        ]);
        User::factory(10)->create();
        DB::table('suppliers')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'phone' => Hash::make('password'),
        ]);
        DB::table('customers')->insert([
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
    }
}