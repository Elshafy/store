<?php

namespace Database\Seeders;

use App\Models\Import;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ImportSeeder extends Seeder
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

            Import::factory(2)->create([
                'item_id' => Item::inRandomOrder()->first()->id,
                'supplier_id' => Supplier::inRandomOrder()->first()->id
            ]);
        }
    }
}