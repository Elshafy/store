<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $items = Item::factory(5)->create(['category_id' => Category::inRandomOrder()->first()->id]);
        $items2 = Item::factory(5)->create(['category_id' => Category::inRandomOrder()->first()->id]);
    }
}
