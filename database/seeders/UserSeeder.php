<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();

        // Create admin
        User::create([
            'name'     => 'Demo Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('admin'),
        ]);

        User::factory(10)->create();
    }
}