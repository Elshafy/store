<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Export;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ExportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 1; $i < 20; $i++) {

            Export::factory(2)->create([
                'item_id' => Item::inRandomOrder()->first()->id,
                'customer_id' => Customer::inRandomOrder()->first()->id
            ]);
        }
    }
}