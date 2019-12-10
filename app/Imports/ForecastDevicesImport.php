<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\Location;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\ForecastDevice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ForecastDevicesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        // maybe there are some missing
        $odm = Account::firstOrCreate(['name' => 'ODM', 'level_type' => 'Category', 'parent_id' => 1]);
        $oem = Account::firstOrCreate(['name' => 'OEM', 'level_type' => 'Category', 'parent_id' => 1]);
        $carrier = Account::firstOrCreate(['name' => 'Carrier', 'level_type' => 'Category', 'parent_id' => 1]);

        foreach ($collection as $index => $row) {

            $product = [];
            //
            if ($row['oem']) {
                $oemAccount = Account::where('name', $row['oem'])->where('parent_id', $oem->id)->first();
                if ($oemAccount) {
                    $product['oem_id'] = $oemAccount->id;
                } else {
                    Log::info('['. $index .']' . 'oem not exist');
                    continue;
                }
            } else {
                $product['oem_id'] = 0;
            }

            if ($row['odm']) {
                $odmAccount = Account::where('name', $row['odm'])->where('parent_id', $odm->id)->first();
                if ($odmAccount) {
                    $product['odm_id'] = $odmAccount->id;
                } else {
                    Log::info('['. $index .']' . 'odm not exist');
                    continue;
                }
            } else {
                $product['odm_id'] = 0;
            }

            if ($row['carrier']) {
                $carrierAccount = Account::where('name', $row['carrier'])->where('parent_id', $carrier->id)->first();
                if ($carrierAccount) {
                    $product['carrier_id'] = $carrierAccount->id;
                } else {
                    Log::info('['. $index .']' . 'carrier_id not exist');
                    continue;
                }
            } else {
                $product['carrier_id'] = 0;
            }

            if ($row['connectivity']) {
                $product['connectivity'] = $row['connectivity'];
            }

            $product['type'] = $row['type'];
            $product['brand'] = $row['brand']? $row['brand']: '';
            $product['licensee'] = $row['licensee'];
            $product['name'] = $row['project'];

            $project = Project::firstOrCreate($product);

            if ($project->wasRecentlyCreated) {
                Log::info('['. $index .']' . 'project not exist, created');
            }

            $location = Location::where('level_type', 'Country')->where('name', $row['country'])->first();
            if (!$location){
                Log::info('['. $index .']' . 'Location not exist, created');
                continue;
            }

            $keys = array_keys($row->all());

            $dates = array_filter($keys, function ($value){
                    if (preg_match('/^\d{4}_(q1|q2|q3|q4){1}/', $value)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            );

            $forecastDevice = [
                'model_id' => 1,
                'model_vid' => 1,
                'project_id' => $project->id,
                'location_id' => $location->id,
            ];
            foreach ($dates as $date) {
                [$y, $q] = preg_split('/_/', $date);
                $d = [];
                switch ($q){
                    case 'q1':
                        $d['date_from'] = $y . '-' . 1 . '-1';
                        $d['date_to'] = $y . '-' . 3 . '-1';
                        break;
                    case 'q2':
                        $d['date_from'] = $y . '-' . 4 . '-1';
                        $d['date_to'] = $y . '-' . 6 . '-1';
                        break;
                    case 'q3':
                        $d['date_from'] = $y . '-' . 7 . '-1';
                        $d['date_to'] = $y . '-' . 9 . '-1';
                        break;
                    case 'q4':
                        $d['date_from'] = $y . '-' . 10 . '-1';
                        $d['date_to'] = $y . '-' . 12 . '-1';
                        break;
                }

                $date_from = Carbon::parse($d['date_from']);
                $date_to = Carbon::parse($d['date_to']);
                $count = ($date_to->year - $date_to->year) * 12 + $date_to->month - $date_from->month + 1;
                $d['quantity'] = trim($row[$date])?$row[$date] / $count: 0;
                while ($date_from->lte($date_to)) {
                    $d['date'] = $date_from->toDateString();

                    $result = ForecastDevice::firstOrCreate(array_merge($forecastDevice, $d));
                    if ($result->wasRecentlyCreated) {
//                    Log::info(print_r(array_merge($forecastDevice, $d), true));
//                    Log::info('['. $index .'] create success.');
                    } else {
                        Log::info(print_r(array_merge($forecastDevice, $d), true));
                        Log::info('['. $index .'] duplicate.');
                    }

                    $date_from->addMonth();
                }


            }

        }
    }

}
