<?php

namespace App\Imports;

use App\Models\Licensee;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LicenseeImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $licensee = Licensee::firstOrCreate(['name' => trim($row['brand'])]);
        }
    }
}
