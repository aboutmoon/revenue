<?php

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Criteria;

class CriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();

        foreach ($items as $index => $item)
        {
            Criteria::create(['name'=>'Criteria_' . $index, 'item_id' => $item->id]);
            Criteria::create(['name'=>'Criteria_' . $index . $index, 'item_id' => $item->id]);
            Criteria::create(['name'=>'Criteria_' . $index . $index . $index, 'item_id' => $item->id]);
        }
    }
}
