<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            //category
            $category = Item::firstOrCreate(['name' => trim($row['category']), 'level_type' => 'Category', 'parent_id' => 0]);

            //item
            $item = Item::firstOrCreate(['name' => $row['item'], 'level_type' => 'Item', 'parent_id' => $category->id]);
        }
    }
}
