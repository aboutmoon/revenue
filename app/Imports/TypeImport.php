<?php

namespace App\Imports;

use App\Models\Type;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TypeImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $row) {
            $licensee = Type::firstOrCreate(['name' => trim($row['name'])]);
        }
    }
}
