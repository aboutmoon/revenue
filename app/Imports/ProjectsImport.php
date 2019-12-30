<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\Account;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        $odm = Account::firstOrCreate(['name' => 'ODM', 'level_type' => 'Category', 'parent_id' => 1]);
        $oem = Account::firstOrCreate(['name' => 'OEM', 'level_type' => 'Category', 'parent_id' => 1]);
        $carrier = Account::firstOrCreate(['name' => 'Carrier', 'level_type' => 'Category', 'parent_id' => 1]);

        foreach ($collection as $row) {
            $product = [];

            $oemAccount = Account::where('name', $row['oem'])->where('parent_id', $oem->id)->first();
            if ($oemAccount) {
                $product['oem_id'] = $oemAccount->id;
            } else {
                $product['oem_id'] = 0;
            }

            $odmAccount = Account::where('name', $row['odm'])->where('parent_id', $odm->id)->first();
            if ($odmAccount) {
                $product['odm_id'] = $odmAccount->id;
            } else {
                $product['odm_id'] = 0;
            }

            $carrierAccount = Account::where('name', $row['carrier'])->where('parent_id', $carrier->id)->first();
            if ($carrierAccount) {
                $product['carrier_id'] = $carrierAccount->id;
            } else {
                $product['carrier_id'] = 0;
            }

            $product['type'] = $row['type']? $row['type']: '';
            $product['brand'] = $row['brand']? $row['brand']: '';
            $product['confidence'] = $row['confidence']? $row['confidence']: '';
//            $product['licensee'] = $row['licensee']? $row['licensee']: '';
//            $product['connectivity'] = $row['connectivity']? $row['connectivity']: '';

            Project::firstOrCreate($product);
        }
    }

}
