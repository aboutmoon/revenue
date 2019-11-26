<?php

namespace App\Imports;

use App\Models\Account;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        $odm = Account::firstOrCreate(['name' => 'ODM', 'level_type' => 'Category', 'parent_id' => 1]);
        $oem = Account::firstOrCreate(['name' => 'OEM', 'level_type' => 'Category', 'parent_id' => 1]);
//        $chipset = Account::firstOrCreate(['name' => 'Chipset', 'level_type' => 'Category', 'parent_id' => 1]);
        $carrier = Account::firstOrCreate(['name' => 'Carrier', 'level_type' => 'Category', 'parent_id' => 1]);
        foreach ($collection as $row) {
            if ($row['odm'] && $row['odm'] != 'none') {
                Account::firstOrCreate(['name' => $row['odm'], 'level_type' => 'Account', 'parent_id' => $odm->id]);
            }

            if ($row['oem'] && $row['oem'] != 'none') {
                Account::firstOrCreate(['name' => $row['oem'], 'level_type' => 'Account', 'parent_id' => $oem->id]);
            }

//            if ($row['chipset'] && $row['chipset'] != 'none') {
//                Account::firstOrCreate(['name' => $row['chipset'], 'level_type' => 'Account', 'parent_id' => $chipset->id]);
//            }

            if ($row['carrier'] && $row['carrier'] != 'none') {
                Account::firstOrCreate(['name' => $row['carrier'], 'level_type' => 'Account', 'parent_id' => $carrier->id]);
            }
        }
    }

}
