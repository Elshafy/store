<?php

namespace Database\Seeders;

use App\Models\User;
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
    }
}