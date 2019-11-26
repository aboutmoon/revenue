<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Criteria;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CriteriaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $item = $row['item'];
            $category = $row['category'];

            $item = Item::with('parent')->whereHas('parent', function ($q) use ($category) {
                $q->where('name', $category);
            })->where('name', $item)->first();

            if ($item) {
                Criteria::firstOrCreate(['name' => $row['parameters'], 'item_id' => $item->id]);
            }
        }
    }

}
